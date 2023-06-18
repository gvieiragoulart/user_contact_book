<?php

namespace App\Repositories\Eloquent;

use App\Models\User as ModelsUser;
use Core\Domain\Entity\User;
use Core\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(ModelsUser $model)
    {
        $this->model = $model;
    }

    public function create(User $contact): User
    {
        $user = $this->model->create(
            $contact->toArray()
        );

        return $this->mapModelToEntity($user);
    }

    public function getUserByEmail(string $email): ModelsUser
    {
        return $this->model->where('email', $email)->firstOrFail();
    }

    private function mapModelToEntity(ModelsUser $model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password
        );
    }
}
