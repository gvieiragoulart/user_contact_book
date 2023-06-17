<?php
namespace App\Services;

use App\Exceptions\LoginException;
use App\Helpers\JwtHelper;
use Core\Domain\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService {
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws LoginException
     */
    public function execute(array $data): string
    {
        if (!Auth::attempt(
            [
                'email'    => $data['email'],
                'password' => $data['password']
            ]
        )
        ) throw new LoginException;

        $user = $this->repository->getUserByEmail($data['email']);

        $token = JwtHelper::makeToken($user);

        return $token;
    }
}
