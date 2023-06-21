<?php

namespace Tests\Unit\Domain\UseCase\Contact;

use App\Services\S3\S3Service;
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

    public $mockS3;

    public function testCreateNewContact()
    {
        $id = Uuid::uuid4()->toString();
        $userId = Uuid::uuid4()->toString();
        $name = 'New Contact';
        $secondName = 'Second Name Contact';
        $number = '16123456789';
        $email = 'teste@teste.com';
        $image_path = '';

        $this->mockEntity = Mockery::mock(Contact::class);
        $this->mockEntity->id = $id;
        $this->mockEntity->userId = $userId;
        $this->mockEntity->name = $name;
        $this->mockEntity->secondName = $secondName;
        $this->mockEntity->number = $number;
        $this->mockEntity->email = $email;
        $this->mockEntity->image_path = $image_path;
        $this->mockEntity->shouldReceive('id')->andReturn(Uuid::uuid4()->toString());

        $this->mockRepo = Mockery::mock(ContactRepositoryInterface::class);
        $this->mockRepo->shouldReceive('create')->andReturn($this->mockEntity);

        $this->mockS3 = Mockery::mock(S3Service::class);

        $mockInputDto = new CreateContactInputDto(
            userId: $userId,
            name: $name,
            secondName: $secondName,
            number: $number,
            email: $email,
            image: $image_path,
        );

        $useCase = new CreateContactUseCase($this->mockRepo, $this->mockS3);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CreateContactOutputDto::class, $response);
        $this->assertEquals($response->id, $this->mockEntity->id());
        $this->assertEquals($response->user_id, $this->mockEntity->userId);
        $this->assertEquals($response->name, $this->mockEntity->name);
        $this->assertEquals($response->second_name, $this->mockEntity->secondName);
        $this->assertEquals($response->number, $this->mockEntity->number);
        $this->assertEquals($response->email, $this->mockEntity->email);

        Mockery::close();
    }
}
