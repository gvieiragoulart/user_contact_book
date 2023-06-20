<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use Core\UseCase\Contact\CreateContactUseCase;
use Core\UseCase\Contact\DeleteContactUseCase;
use Core\UseCase\Contact\FindAllContactUseCase;
use Core\UseCase\Contact\FindContactUseCase;
use Core\UseCase\Contact\UpdateContactUseCase;
use Core\UseCase\DTO\Contact\Create\CreateContactInputDto;
use Core\UseCase\DTO\Contact\FindAll\FindAllContactsInputDto;
use Core\UseCase\DTO\Contact\Update\UpdateContactInputDto;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * Busca todos os contatos do usuário logado com paginação.
     *
     * @header Authorization Bearer {token}
     */
    public function index(Request $request, FindAllContactUseCase $useCase)
    {
        $contacts = $useCase->execute(
            input: new FindAllContactsInputDto(
                userId: JwtHelper::getUserId(),
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPage: (int) $request->get('total_page', 15),
            )
        );

        return $this->sendPaginatedData(
            message: __('controller.basicCrud.index', ['value' => 'Companies']),
            total: $contacts->total,
            nextPage: $contacts->next_page_url,
            data: ContactResource::collection($contacts->items)
        );
    }

    /**
     * Insere um novo contato para o usuário logado.
     *
     * @bodyParam name string required Nome do contato. Example: João
     * @bodyParam secondName string Nome do contato. Example: Silva
     * @bodyParam number string required Número do contato. Example: (11)999999999
     * @bodyParam email string required Email do contato. Example: joaosilva@teste.com
     *
     * @header Authorization Bearer {token}
     * @header Content-Type multipart/form-data
     */
    public function store(CreateContactRequest $request, CreateContactUseCase $useCase)
    {
        $contact = $useCase->execute(
            input: new CreateContactInputDto(
                userId: JwtHelper::getUserId(),
                name: $request->name,
                secondName: $request->secondName ?? '',
                number: $request->number,
                email: $request->email,
                image: $request->image ?? ''
            )
        );

        return $this->sendDataWithMessage(
            message: __('controller.basicCrud.create', ['value' => 'Company']),
            data: ContactResource::make($contact),
            statusCode: Response::HTTP_CREATED
        );
    }

    /**
     * Busca um contato do usuário logado.
     *
     * @queryParam id required Id do contato. Example: ecd4f3ff-7e8d-4358-ac74-f997955c7c86
     *
     * @header Authorization Bearer {token}
     */
    public function show(string $id, FindContactUseCase $useCase)
    {
        $contact = $useCase->execute($id);

        return $this->sendDataWithMessage(
            message: __('controller.basicCrud.create', ['value' => 'Company']),
            data: ContactResource::make($contact),
            statusCode: Response::HTTP_OK
        );
    }

    /**
     * Atualiza um contato do usuário logado.
     *
     * @queryParam id required Id do contato. Example: ecd4f3ff-7e8d-4358-ac74-f997955c7c86
     *
     * @bodyParam name string Nome do contato. Example: João
     * @bodyParam secondName string Nome do contato. Example: Silva
     * @bodyParam number string Número do contato. Example: (11)999999999
     * @bodyParam email string Email do contato. Example: joaosilva@teste.com
     *
     * @header Authorization Bearer {token}
     */
    public function update(string $id, UpdateContactRequest $request, UpdateContactUseCase $useCase)
    {
        $contact = $useCase->execute(
            input: new UpdateContactInputDto(
                id: $id,
                userId: JwtHelper::getUserId(),
                name: $request->name,
                secondName: $request->secondName,
                number: $request->number,
                email: $request->email,
                image: $request->image ?? null
            )
        );

        return $this->sendDataWithMessage(
            message: __('controller.basicCrud.create', ['value' => 'Company']),
            data: ContactResource::make($contact),
            statusCode: Response::HTTP_OK
        );
    }

    /**
     * Deleta um contato do usuário logado.
     *
     * @queryParam id required Id do contato. Example: ecd4f3ff-7e8d-4358-ac74-f997955c7c86
     *
     * @header Authorization Bearer {token}
     */
    public function destroy($id, DeleteContactUseCase $useCase)
    {
        $useCase->execute($id);

        return $this->sendMessage(
            message: __('controller.basicCrud.create', ['value' => 'Company']),
            statusCode: Response::HTTP_OK
        );
    }
}
