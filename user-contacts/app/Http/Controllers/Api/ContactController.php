<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Core\UseCase\Contact\CreateContactUseCase;
use Core\UseCase\Contact\DeleteContactUseCase;
use Core\UseCase\Contact\FindAllContactUseCase;
use Core\UseCase\Contact\FindContactUseCase;
use Core\UseCase\Contact\UpdateContactUseCase;
use Core\UseCase\DTO\Contact\Create\CreateContactInputDto;
use Core\UseCase\DTO\Contact\FindAll\FindAllContactsInputDto;
use Core\UseCase\DTO\Contact\Update\UpdateContactInputDto;
use Illuminate\Http\Request;

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

        return response()->json($contacts);
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
                image: $request->image ?? null
            )
        );

        return response()->json($contact);
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

        return response()->json($contact);
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
                email: $request->email
            )
        );

        return response()->json($contact);
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

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
