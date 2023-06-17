<?php

namespace Core\UseCase\Contact;

use Core\Domain\Entity\Contact;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\Create\CreateContactInputDto;
use Core\UseCase\DTO\Contact\Create\CreateContactOutputDto;

class CreateContactUseCase
{
    protected ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateContactInputDto $input): CreateContactOutputDto
    {
        $contact = new Contact(
            userId: $input->userId,
            name: $input->name,
            secondName: $input->secondName,
            number: $input->number,
            email: $input->email
        );

        $contact = $this->repository->create($contact);
        return new CreateContactOutputDto(
            id: $contact->id(),
            userId: $contact->userId,
            name: $contact->name,
            secondName: $contact->secondName,
            number: $contact->number,
            email: $contact->email
        );
    }
}