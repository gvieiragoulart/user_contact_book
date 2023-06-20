<?php

namespace Core\UseCase\Contact;

use App\Services\S3\S3Service;
use Core\Domain\Entity\Contact;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\Create\CreateContactInputDto;
use Core\UseCase\DTO\Contact\Create\CreateContactOutputDto;

class CreateContactUseCase
{
    protected ContactRepositoryInterface $repository;
    protected S3Service $s3Service;


    public function __construct(ContactRepositoryInterface $repository, S3Service $s3Service)
    {
        $this->repository = $repository;
        $this->s3Service = $s3Service;
    }

    public function execute(CreateContactInputDto $input): CreateContactOutputDto
    {
        (empty($input->image)) ?: $imagePath = $this->s3Service->putObjectOnBucket($input->image);

        $contact = new Contact(
            userId: $input->userId,
            name: $input->name,
            secondName: $input->secondName,
            number: $input->number,
            email: $input->email,
            imagePath: $imagePath ?? $input->image,
        );

        $contact = $this->repository->create($contact);

        return new CreateContactOutputDto(
            id: $contact->id(),
            user_id: $contact->userId,
            name: $contact->name,
            second_name: $contact->secondName,
            number: $contact->number,
            email: $contact->email,
            imagePath: $contact->imagePath,
        );
    }
}
