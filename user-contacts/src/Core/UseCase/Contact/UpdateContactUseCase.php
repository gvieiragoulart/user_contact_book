<?php

namespace Core\UseCase\Contact;

use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\Update\UpdateContactInputDto;
use Core\UseCase\DTO\Contact\Update\UpdateContactOutputDto;

class UpdateContactUseCase
{
    protected ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UpdateContactInputDto $input): UpdateContactOutputDto
    {
        $contact = $this->repository->findById($input->id);

        $contact->update(
            name: $input->name,
            secondName: $input->secondName,
            number: $input->number,
            email: $input->email
        );

        $contact = $this->repository->update($contact);

        return new UpdateContactOutputDto(
            id: $contact->id(),
            userId: $contact->userId,
            name: $contact->name,
            secondName: $contact->secondName,
            number: $contact->number,
            email: $contact->email
        );
    }
}
