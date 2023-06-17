<?php

namespace Core\Domain\Repository;

use App\Models\User as ModelsUser;
use Core\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function create(User $contact): User;
    public function getUserByEmail(string $email): ModelsUser;
}