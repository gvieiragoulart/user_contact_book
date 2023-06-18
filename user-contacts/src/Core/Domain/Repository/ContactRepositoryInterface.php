<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Contact;

interface ContactRepositoryInterface
{
    public function create(Contact $contact): Contact;

    public function update(Contact $data): Contact;

    public function delete(string $id): bool;

    public function findById(string $id): Contact;

    public function paginate(string $userId, string $filter = '', string $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;

    public function findAll(string $filter = '', string $order = 'DESC'): array;
}
