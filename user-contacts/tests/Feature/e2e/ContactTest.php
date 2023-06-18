<?php

namespace Tests\Feature\e2e;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class ContactTest extends TestCase
{
    use WithoutMiddlewareTrait;

    protected $endpoint = 'api/contacts';
    protected $user;
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $token = $this->getToken();

        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ];
    }

    protected function getToken(): string
    {
        $this->user = User::factory()->create([
            'password' => bcrypt('123456'),
        ]);

        $data = [
            'email' => $this->user->email,
            'password' => '123456',
        ];
 
        $response = $this->postJson('api/auth/login', $data);
        return $response['access_token'];
    }

    public function testCreate()
    {
        $data = [
            'name' => 'João',
            'second_name' => 'Silva',
            'number' => '(16)123456789',
            'email' => 'joao@teste.com',
        ];
 
        $response = $this->postJson($this->endpoint, $data, $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testCreateReturn422WithoutName()
    {
        $data = [
            'second_name' => 'Silva',
            'number' => '(16)123456789',
            'email' => 'teste@teste.com',
        ];

        $response = $this->postJson($this->endpoint, $data, $this->headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testGetContact()
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson("$this->endpoint/$contact->id", $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'secondName',
            'number',
            'email',
        ]);
    }

    public function testGetAllContactsPaginated()
    {
        Contact::factory()->count(15)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson("$this->endpoint", $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'items',
            'total',
            'current_page',
            'last_page',
            'first_page',
            'per_page',
            'to',
            'from',
        ]);
        $response->assertJsonCount(15, 'items');
    }

    public function testDelete()
    {
        $contact = Contact::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson("$this->endpoint/$contact->id", [], $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseEmpty('contacts');
    }

    public function testUpdate()
    {
        $contact = Contact::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $data = [
            'name' => 'name updated',
            'email' => 'emailupdated@test.com',
        ];

        $response = $this->putJson("$this->endpoint/$contact->id", $data, $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}