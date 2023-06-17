<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicMethods;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class User
{
    use MagicMethods;

    public function __construct(
        public Uuid|string $id = '',
        public string $name = '',
        public string $email = '',
        public string $password = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::generate();
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        
        $this->validate();
    }

    public function update(?string $name, ?string $email, ?string $password): void
    {
        $this->name = $name ?? $this->name;
        $this->email = $email ?? $this->email;
        $this->password = $password ?? $this->password;

        $this->validate();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'password' => $this->password,
            'email' => $this->email,
        ];
    }

    private function validate()
    {
        DomainValidation::notNull($this->id, 'Id is required');
        DomainValidation::notNull($this->name, 'Name is required');
        DomainValidation::strMaxLenght($this->name, 100, 'Name should not greater than 100 characters');
        DomainValidation::strMinLenght($this->name, 3, 'Name should not less than 3 characters');
        DomainValidation::notNull($this->email, 'Email is required');
    }
}