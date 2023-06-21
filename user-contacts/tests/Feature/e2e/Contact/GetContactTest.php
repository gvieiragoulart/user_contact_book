<?php

namespace Tests\Feature\e2e\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class GetContactTest extends TestCase
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


    public function testGetContact()
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson("$this->endpoint/$contact->id", $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($contact->id, $response['content']['id']);
        $this->assertEquals($contact->name, $response['content']['name']);
        $this->assertEquals($contact->second_name, $response['content']['secondName']);
        $this->assertEquals($contact->number, $response['content']['number']);
        $this->assertEquals($contact->email, $response['content']['email']);
        $this->assertEquals($contact->image_path, $response['content']['image_path']);
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
