<?php

namespace Tests\Unit\Domain\UseCase\User;

use App\Services\SQS\SQSService;
use Core\Domain\Entity\User;
use Core\Domain\Repository\UserRepositoryInterface;
use Core\UseCase\DTO\Register\RegisterUserInputDto;
use Core\UseCase\DTO\Register\RegisterUserOutputDto;
use Core\UseCase\User\RegisterUserUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateUserUseCaseTest extends TestCase
{
    public $mockRepo;
    public $mockSqsService;

    public $mockEntity;

    public $mockInputDto;

    public function testCreateNewUser()
    {
        $id = Uuid::uuid4()->toString();
        $name = 'New User';
        $email = 'teste@teste.com';
        $password = '12345678';

        $this->mockEntity = Mockery::mock(User::class);
        $this->mockEntity->id = $id;
        $this->mockEntity->name = $name;
        $this->mockEntity->email = $email;
        $this->mockEntity->password = $password;
        $this->mockEntity->shouldReceive('id')->andReturn($id);

        $this->mockRepo = Mockery::mock(UserRepositoryInterface::class);
        $this->mockRepo->shouldReceive('create')->andReturn($this->mockEntity);

        $this->mockSqsService = Mockery::mock(SQSService::class);
        $this->mockSqsService->shouldReceive('sendMessage')->andReturn(true);

        $mockInputDto = new RegisterUserInputDto(
            name: $name,
            password: $password,
            email: $email
        );

        $useCase = new RegisterUserUseCase($this->mockRepo, $this->mockSqsService);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(RegisterUserOutputDto::class, $response);
        $this->assertEquals($response->id, $this->mockEntity->id());
        $this->assertEquals($response->name, $this->mockEntity->name);
        $this->assertEquals($response->email, $this->mockEntity->email);

        Mockery::close();
    }
}
