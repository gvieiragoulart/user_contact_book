<?php

namespace Core\UseCase\Contact;

use Core\Domain\Repository\ContactRepositoryInterface;
use Core\UseCase\DTO\Contact\FindAll\FindAllContactsInputDto;
use Core\UseCase\DTO\Contact\FindAll\FindAllContactsOutputDto;

class FindAllContactUseCase
{
    protected ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FindAllContactsInputDto $input): FindAllContactsOutputDto
    {
        $contacts = $this->repository->paginate(
            userId: $input->userId,
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage,
        );

        return new FindAllContactsOutputDto(
            items: $contacts->items(),
            total: $contacts->total(),
            current_page: $contacts->currentPage(),
            last_page: $contacts->lastPage(),
            first_page: $contacts->firstPage(),
            per_page: $contacts->perPage(),
            to: $contacts->to(),
            from: $contacts->from(),
        );
    }
}
