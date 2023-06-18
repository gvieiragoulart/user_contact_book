<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Contact as ModelContact;
use App\Models\User;
use App\Repositories\Eloquent\ContactRepository;
use Core\Domain\Entity\Contact as EntityContact;
use Core\Domain\Repository\ContactRepositoryInterface;
use Tests\TestCase;

class ContactEloquentRepositoryTest extends TestCase
{
    public function testInsert()
    {
        $repository = new ContactRepository(new ModelContact());

        $user = User::factory()->create();

        $entity = new EntityContact(
            userId: $user->id,
            name: 'name',
            secondName: 'second_name',
            number: '12345678910',
            email: 'teste@teste.com',
        );
        $response = $repository->create($entity);

        $this->assertInstanceOf(ContactRepositoryInterface::class, $repository);
        $this->assertInstanceOf(EntityContact::class, $response);
        $this->assertDatabaseHas('contacts', [
            'name'  => $entity->name,
        ]);
        $this->assertEquals($entity->name, $response->name);
        $this->assertEquals($entity->secondName, $response->secondName);
        $this->assertEquals($entity->email, $response->email);
        $this->assertEquals($entity->number, $response->number);
        $this->assertEquals($entity->userId, $response->userId);
    }
}
