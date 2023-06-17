<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicMethods;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Contact
{
    use MagicMethods;

    public function __construct(
        public Uuid|string $id = '',
        public Uuid|string $userId = '',
        public string $name = '',
        public string $secondName = '',
        public string $number = '',
        public string $email = ''
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::generate();

        $this->validate();
    }

    public function update(?string $name, ?string $secondName, ?string $number, ?string $email)
    {
        $this->name = $name ?? $this->name;
        $this->secondName = $secondName ?? $this->secondName;
        $this->number = $number ?? $this->number;
        $this->email = $email ?? $this->email;

        $this->validate();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'second_name' => $this->secondName,
            'number' => $this->number,
            'email' => $this->email,
        ];
    }

    private function validate()
    {
        DomainValidation::notNull($this->id, 'Id is required');
        DomainValidation::notNull($this->userId, 'userId is required');
        DomainValidation::notNull($this->name, 'Name is required');
        DomainValidation::strMaxLenght($this->name, 100, 'Name should not greater than 100 characters');
        DomainValidation::strMinLenght($this->name, 3, 'Name should not less than 3 characters');
        DomainValidation::notNull($this->number, 'Number is required');
        DomainValidation::notNull($this->email, 'Email is required');
        DomainValidation::strCanNullAndMaxLenght($this->secondName, 100, 'Second name should not greater than 100 characters');
    }
}