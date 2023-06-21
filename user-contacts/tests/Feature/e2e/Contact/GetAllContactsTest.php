<?php

namespace Tests\Feature\e2e\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class GetAllContactTest extends TestCase
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


    public function testGetAllContactsPaginated()
    {
        Contact::factory()->count(15)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson("$this->endpoint", $this->headers);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'total',
            'nextPageUrl',
            'content' => [
                '*' => [
                    'id',
                    'name',
                    'secondName',
                    'number',
                    'email',
                    'image_path'
                ],
            ],
        ]);
        $response->assertJsonCount(15, 'content');
    }
}
