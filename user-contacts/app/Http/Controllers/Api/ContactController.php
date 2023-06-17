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

    public function store(CreateContactRequest $request, CreateContactUseCase $useCase)
    {
        $contact = $useCase->execute(
            input: new CreateContactInputDto(
                userId: JwtHelper::getUserId(),
                name: $request->name,
                secondName: $request->secondName ?? '',
                number: $request->number,
                email: $request->email
            )
        );

        return response()->json($contact);
    }

    public function show(string $id, FindContactUseCase $useCase)
    {
        $contact = $useCase->execute($id);

        return response()->json($contact);
    }

    public function update(string $id,UpdateContactRequest $request, UpdateContactUseCase $useCase)
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

    public function destroy($id, DeleteContactUseCase $useCase)
    {
        $useCase->execute($id);

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}