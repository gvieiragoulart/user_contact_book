<?php

namespace Tests\Feature\e2e;

use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegister()
    {
        $data = [
            'name' => 'João',
            'password' => '123456',
            'email' => 'joao@teste.com',
        ];

        $response = $this->postJson('api/register', $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testRegisterReturn422WithoutName()
    {
        $data = [
            'password' => '123456',
            'email' => 'joao@teste.com',
        ];

        $response = $this->postJson('api/register', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseEmpty('users');
    }

    public function testRegisterReturn422WithoutPassword()
    {
        $data = [
            'name' => 'João',
            'email' => 'joao@teste.com',
        ];

        $response = $this->postJson('api/register', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseEmpty('users');
    }

    public function testRegisterReturn422WithoutEmail()
    {
        $data = [
            'name' => 'João',
            'password' => '123456',
        ];

        $response = $this->postJson('api/register', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseEmpty('users');
    }
}