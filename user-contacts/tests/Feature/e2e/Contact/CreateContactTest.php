<?php

namespace Tests\Feature\e2e\Contact;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class CreateContactTest extends TestCase
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

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'second_name' => $data['second_name'],
            'email' => $data['email'],
            'number' => $data['number'],
        ]);
        $response->assertJsonStructure([
            'message',
            'content' => [
                'id',
                'name',
                'secondName',
                'number',
                'email',
                'image_path'
            ],
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


    public function testCreateReturn422WithoutEmail()
    {
        $data = [
            'name' => 'João',
            'number' => '(16)123456789',
        ];

        $response = $this->postJson($this->endpoint, $data, $this->headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateReturn422WithoutNumber()
    {
        $data = [
            'name' => 'João',
            'email' => 'teste@teste.com',
        ];

        $response = $this->postJson($this->endpoint, $data, $this->headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}