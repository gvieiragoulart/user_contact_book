<?php

namespace Core\UseCase\DTO\Contact;

class ContactOutputDto
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $name,
        public string $second_name,
        public string $number,
        public string $email
    ) {
    }
}
