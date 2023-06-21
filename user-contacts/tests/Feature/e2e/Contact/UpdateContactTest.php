<?php

namespace Tests\Feature\e2e\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class UpdateContactTest extends TestCase
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

    public function testUpdate()
    {
        $contact = Contact::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $data = [
            'name' => 'name updated',
            'secondName' => 'second name updated',
            'email' => 'emailupdated@test.com',
            'number' => '(16)987654321',
        ];

        $response = $this->putJson("$this->endpoint/$contact->id", $data, $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($data['name'], $response['content']['name']);
        $this->assertEquals($data['secondName'], $response['content']['secondName']);
        $this->assertEquals($data['email'], $response['content']['email']);
        $this->assertEquals($data['number'], $response['content']['number']);
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'second_name' => $data['secondName'],
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
}
