<?php

namespace Core\UseCase\User;

use App\Services\SQS\SQSService;
use Core\Domain\Entity\User;
use Core\Domain\Repository\UserRepositoryInterface;
use Core\UseCase\DTO\Register\RegisterUserInputDto;
use Core\UseCase\DTO\Register\RegisterUserOutputDto;
use Exception;
use Illuminate\Support\Facades\Log;

class RegisterUserUseCase
{
    protected UserRepositoryInterface $repository;
    protected SQSService $sqsService;

    public function __construct(UserRepositoryInterface $repository, SQSService $sqsService)
    {
        $this->repository = $repository;
        $this->sqsService = $sqsService;
    }

    public function execute(RegisterUserInputDto $input): RegisterUserOutputDto
    {
        $user = new User(
            name: $input->name,
            password: $input->password,
            email: $input->email
        );

        $user = $this->repository->create($user);

        try {
            $this->sqsService->sendMessage(json_encode([
                'name' => $user->name,
                'email' => $user->email,
            ]));
        } catch (Exception $e) {
            Log::error($e->getMessage(), [
                'message' => 'Error sending message to SQS',
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        return new RegisterUserOutputDto(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }
}    
