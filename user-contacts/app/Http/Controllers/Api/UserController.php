<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Core\UseCase\DTO\Register\RegisterUserInputDto;
use Core\UseCase\User\RegisterUserUseCase;

class UserController extends Controller
{
    /**
     * Registra um novo usuário.
     *
     * @unauthenticated
     *
     * @bodyParam name string required Nome do usuário. Example: João
     * @bodyParam password string required Senha do usuário. Example: 123456
     * @bodyParam email string required Email do usuário. Example: joao@teste.com
     */
    public function register(RegisterUserRequest $request, RegisterUserUseCase $useCase)
    {
        $user = $useCase->execute(
            input: new RegisterUserInputDto(
                name: $request->name,
                password: $request->password,
                email: $request->email
            )
        );

        return response()->json($user);
    }
}
