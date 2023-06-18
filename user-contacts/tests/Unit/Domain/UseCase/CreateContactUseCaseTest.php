<?php

namespace Tests\Unit\Domain\UseCase;

use Core\Domain\Entity\Contact;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\Contact\CreateContactUseCase;
use Core\UseCase\DTO\Contact\Create\CreateContactInputDto;
use Core\UseCase\DTO\Contact\Create\CreateContactOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateContactUseCaseTest extends TestCase
{
    public $mockRepo;

    public $mockEntity;

    public $mockInputDto;

    public function testCreateNewContact()
    {
        $id = Uuid::uuid4()->toString();
        $userId = Uuid::uuid4()->toString();
        $name = 'New Contact';
        $secondName = 'Second Name Contact';
        $number = '16123456789';
        $email = 'teste@teste.com';

        $this->mockEntity = Mockery::mock(Contact::class);
        $this->mockEntity->id = $id;
        $this->mockEntity->userId = $userId;
        $this->mockEntity->name = $name;
        $this->mockEntity->secondName = $secondName;
        $this->mockEntity->number = $number;
        $this->mockEntity->email = $email;
        $this->mockEntity->shouldReceive('id')->andReturn(Uuid::uuid4()->toString());

        $this->mockRepo = Mockery::mock(ContactRepositoryInterface::class);
        $this->mockRepo->shouldReceive('create')->andReturn($this->mockEntity);

        $mockInputDto = new CreateContactInputDto(
            userId: $userId,
            name: $name,
            secondName: $secondName,
            number: $number,
            email: $email
        );

        $useCase = new CreateContactUseCase($this->mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CreateContactOutputDto::class, $response);
        $this->assertEquals($response->id, $this->mockEntity->id());
        $this->assertEquals($response->userId, $this->mockEntity->userId);
        $this->assertEquals($response->name, $this->mockEntity->name);
        $this->assertEquals($response->secondName, $this->mockEntity->secondName);
        $this->assertEquals($response->number, $this->mockEntity->number);
        $this->assertEquals($response->email, $this->mockEntity->email);

        Mockery::close();
    }
}
