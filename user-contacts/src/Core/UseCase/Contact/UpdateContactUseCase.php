<?php

namespace Core\UseCase\Contact;

use App\Services\S3\S3Service;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\Update\UpdateContactInputDto;
use Core\UseCase\DTO\Contact\Update\UpdateContactOutputDto;

class UpdateContactUseCase
{
    protected ContactRepositoryInterface $repository;
    protected S3Service $s3Service;

    public function __construct(ContactRepositoryInterface $repository, S3Service $s3Service)
    {
        $this->repository = $repository;
        $this->s3Service = $s3Service;
    }

    public function execute(UpdateContactInputDto $input): UpdateContactOutputDto
    {
        $contact = $this->repository->findById($input->id);
 
        $imagePath = (empty($input->image)) ? $contact->imagePath : $this->s3Service->putObjectOnBucket($input->image);

        $contact->update(
            name: $input->name,
            secondName: $input->secondName,
            number: $input->number,
            email: $input->email,
            imagePath: $imagePath
        );

        $contact = $this->repository->update($contact);

        return new UpdateContactOutputDto(
            id: $contact->id(),
            userId: $contact->userId,
            name: $contact->name,
            secondName: $contact->secondName,
            number: $contact->number,
            email: $contact->email,
            imagePath: $contact->imagePath ?? '',
        );
    }
}
