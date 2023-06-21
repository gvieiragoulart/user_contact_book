<?php

namespace Core\UseCase\Contact;

use App\Services\S3\S3Service;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\Update\UpdateContactInputDto;
use Core\UseCase\DTO\Contact\Update\UpdateContactOutputDto;
use Core\UseCase\DTO\Contact\Update\UpdateImageContactInputDto;

class UpdateImageContactUseCase
{
    protected ContactRepositoryInterface $repository;
    protected S3Service $s3Service;

    public function __construct(ContactRepositoryInterface $repository, S3Service $s3Service)
    {
        $this->repository = $repository;
        $this->s3Service = $s3Service;
    }

    public function execute(UpdateImageContactInputDto $input): UpdateContactOutputDto
    {
        $contact = $this->repository->findById($input->id);

        $image_path = $this->s3Service->putObjectOnBucket($input->image);

        $contact->update(
            name: $contact->name,
            secondName: $contact->secondName,
            number: $contact->number,
            email: $contact->email,
            image_path: $image_path
        );

        $contact = $this->repository->update($contact);

        return new UpdateContactOutputDto(
            id: $contact->id(),
            user_id: $contact->userId,
            name: $contact->name,
            second_name: $contact->secondName,
            number: $contact->number,
            email: $contact->email,
            image_path: $contact->image_path ?? '',
        );
    }
}
