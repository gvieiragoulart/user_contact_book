<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\User as ModelUser;
use App\Repositories\Eloquent\UserRepository;
use Core\Domain\Entity\User as EntityUser;
use Core\Domain\Repository\UserRepositoryInterface;
use Tests\TestCase;

class UserEloquentRepositoryTest extends TestCase
{
    public function testCreate()
    {
        $repository = new UserRepository(new ModelUser());

        $entity = new EntityUser(
            name: 'name',
            email: 'teste@teste.com',
            password: '123456',
        );

        $response = $repository->create($entity);

        $this->assertInstanceOf(UserRepositoryInterface::class, $repository);
        $this->assertInstanceOf(EntityUser::class, $response);
        $this->assertDatabaseHas('users', [
            'name' => $entity->name,
        ]);
        $this->assertEquals($entity->name, $response->name);
        $this->assertEquals($entity->email, $response->email);
    }

    public function testGetUserByEmail()
    {
        $repository = new UserRepository(new ModelUser());

        $user = ModelUser::factory()->create();

        $response = $repository->getUserByEmail($user->email);

        $this->assertInstanceOf(ModelUser::class, $response);
        $this->assertEquals($user->id, $response->id);
        $this->assertEquals($user->name, $response->name);
        $this->assertEquals($user->email, $response->email);
    }


}
