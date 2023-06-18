<?php

namespace Core\UseCase\DTO\Contact\FindAll;

class FindAllContactsInputDto
{
    public function __construct(
        public string $userId,
        public string $filter = '',
        public string $order = 'DESC',
        public int $page = 1,
        public int $totalPage = 15,
    ) {
    }
}
