<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Faz o login do usuário.
     *
     * @unauthenticated
     *
     * @bodyParam email string required Email do usuário. Example: joao@teste.com
     * @bodyParam password string required Senha do usuário. Example: 123456
     */
    public function login(LoginRequest $request, LoginService $loginService)
    {
        $data = $request->validated();

        try {
            $token = $loginService->execute($data);

            return $this->respondWithToken($token);

        } catch (ServiceException $e) {
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Retorna os dados do usuário logado.
     *
     * @authenticated
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Faz o logout do usuário.
     *
     * @authenticated
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Atualiza o token do usuário.
     *
     * @authenticated
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
        ]);
    }
}
