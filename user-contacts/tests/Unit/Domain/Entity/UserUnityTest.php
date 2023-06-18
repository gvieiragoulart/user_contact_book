<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\User;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

class UserUnityTest extends TestCase
{
    public function testAttributes()
    {
        $user = new User(
            name: 'New User',
            password: 'senhateste',
            email: 'teste@teste.com'
        );

        $this->assertNotEmpty($user->id());
        $this->assertEquals('New User', $user->name);
        $this->assertTrue(password_verify('senhateste', $user->password));
        $this->assertEquals('teste@teste.com', $user->email);
    }

    public function testExpectionName()
    {
        $this->expectException(EntityValidationException::class);

        new User(
            name: 'Ab',
            password: 'senhateste',
            email: 'teste@teste.com'
        );
    }
}
