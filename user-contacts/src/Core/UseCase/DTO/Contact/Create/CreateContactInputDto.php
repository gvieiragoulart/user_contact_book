<?php

namespace Core\UseCase\DTO\Contact\Create;

class CreateContactInputDto
{
    public function __construct(
        public string $userId,
        public string $name,
        public ?string $secondName,
        public string $number,
        public string $email
    ) {
    }
}
