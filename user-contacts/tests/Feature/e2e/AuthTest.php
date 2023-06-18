<?php

namespace Tests\Feature\e2e;

use App\Models\User;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class AuthTest extends TestCase
{
    use WithoutMiddlewareTrait;

    public function testLogin()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => '123456',
        ];
 
        $response = $this->postJson('api/auth/login', $data);
        $response->assertOk();
        $response->assertJsonStructure(['access_token']);
    }

    public function testLoginUnauthorized()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => '1234567',
        ];
 
        $response = $this->postJson('api/auth/login', $data);
        $response->assertUnauthorized();
        $response->assertJsonStructure(['message']);
    }
}