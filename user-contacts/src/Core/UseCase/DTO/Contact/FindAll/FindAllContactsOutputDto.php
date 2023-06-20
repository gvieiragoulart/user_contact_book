<?php

namespace Core\UseCase\DTO\Contact\FindAll;

class FindAllContactsOutputDto
{
    public function __construct(
        public array $items,
        public int $total,
        public int $current_page,
        public int|string $last_page,
        public string $first_page,
        public int $per_page,
        public int $to,
        public int $from,
        public ?string $next_page_url,
    ) {
    }
}
