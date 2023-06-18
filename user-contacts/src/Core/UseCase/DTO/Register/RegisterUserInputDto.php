<?php

namespace Core\UseCase\DTO\Register;

class RegisterUserInputDto
{
    public function __construct(
        public string $name,
        public string $password,
        public string $email,
    ) {
    }
}
