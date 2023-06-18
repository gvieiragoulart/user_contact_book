<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Contact as ModelContact;
use App\Models\User;
use App\Repositories\Eloquent\ContactRepository;
use Core\Domain\Entity\Contact as EntityContact;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Tests\TestCase;

class ContactEloquentRepositoryTest extends TestCase
{
    public function testCreate()
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
            'name' => $entity->name,
        ]);
        $this->assertEquals($entity->name, $response->name);
        $this->assertEquals($entity->secondName, $response->secondName);
        $this->assertEquals($entity->email, $response->email);
        $this->assertEquals($entity->number, $response->number);
        $this->assertEquals($entity->userId, $response->userId);
    }
    
    public function testUpdate()
    {
        $repository = new ContactRepository(new ModelContact());

        $contact = ModelContact::factory()->create();

        $entity = new EntityContact(
            id: $contact->id,
            userId: $contact->user_id,
            name: 'updated name',
            secondName: $contact->second_name,
            number: $contact->number,
            email: $contact->email,
        );

        $entity->update(
            name: 'updated name',
            secondName: 'updated second name',
            number: '1234567891033',
            email: 'updateemail@email.com',
        );

        $response = $repository->update($entity);

        $this->assertInstanceOf(EntityContact::class, $response);
        $this->assertNotEquals($response->name, $contact->name);
        $this->assertEquals('updated name', $response->name);
    }

    public function testDelete()
    {
        $repository = new ContactRepository(new ModelContact());

        $contact = ModelContact::factory()->create();

        $response = $repository->delete($contact->id);

        $this->assertTrue($response);
        $this->assertDatabaseEmpty('contacts');
    }

    public function testFindById()
    {
        $repository = new ContactRepository(new ModelContact());

        $contact = ModelContact::factory()->create();

        $response = $repository->findById($contact->id);

        $this->assertInstanceOf(EntityContact::class, $response);
        $this->assertEquals($contact->id, $response->id);
        $this->assertEquals($contact->name, $response->name);
        $this->assertEquals($contact->second_name, $response->secondName);
        $this->assertEquals($contact->email, $response->email);
        $this->assertEquals($contact->number, $response->number);
        $this->assertEquals($contact->user_id, $response->userId);
    }

    public function testFindAll()
    {
        $repository = new ContactRepository(new ModelContact());

        $contact = ModelContact::factory()->create();

        $response = $repository->findAll();

        $this->assertIsArray($response);
        $this->assertEquals($contact->id, $response[0]->id);
        $this->assertEquals($contact->name, $response[0]->name);
        $this->assertEquals($contact->second_name, $response[0]->second_name);
        $this->assertEquals($contact->email, $response[0]->email);
        $this->assertEquals($contact->number, $response[0]->number);
        $this->assertEquals($contact->user_id, $response[0]->user_id);
    }

    public function testPaginate()
    {
        $repository = new ContactRepository(new ModelContact());

        $contacts = ModelContact::factory()->count(20)->create();

        $response = $repository->paginate(
            userId: $contacts[0]->user_id,
        );

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertEquals(15, $response->perPage());
        $this->assertNotEmpty($response->items());
    }
}
