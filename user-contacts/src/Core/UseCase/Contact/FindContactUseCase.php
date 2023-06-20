<?php

namespace Core\UseCase\Contact;

use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\ContactOutputDto;

class FindContactUseCase
{
    protected ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id): ContactOutputDto
    {
        $contact = $this->repository->findById($id);

        return new ContactOutputDto(
            id: $contact->id(),
            user_id: $contact->userId,
            name: $contact->name,
            second_name: $contact->secondName,
            number: $contact->number,
            email: $contact->email
        );
    }
}
