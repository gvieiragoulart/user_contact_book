<?php

namespace Core\UseCase\DTO\Register;

class RegisterUserOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email
    ) {
    }
}