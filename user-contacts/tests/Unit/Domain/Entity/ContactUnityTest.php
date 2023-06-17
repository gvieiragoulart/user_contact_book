<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Contact;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ContactUnityTest extends TestCase
{
    public function testAttributes()
    {
        $contact = new Contact(
            userId: Uuid::uuid4()->toString(),
            name: 'New Contact',
            secondName: 'Second Name Contact',
            number: '16123456789',
            email: 'teste@teste.com'
        );

        $this->assertNotEmpty($contact->id());
        $this->assertEquals('New Contact', $contact->name);
        $this->assertEquals('Second Name Contact', $contact->secondName);
        $this->assertEquals('16123456789', $contact->number);
        $this->assertEquals('teste@teste.com', $contact->email);
    }

    public function testUpdate()
    {
        $uuid = Uuid::uuid4()->toString();

        $contact = new Contact(
            id: $uuid,
            userId: Uuid::uuid4()->toString(),
            name: 'New Contact',
            secondName: 'Second Name Contact',
            number: '16123456789',
            email: 'teste@teste.com'
        );

        $contact->update(
            name: 'New Contact Updated',
            secondName: 'Second Name Contact Updated',
            number: '16123456787',
            email: 'testeupdated@teste.com'
        );

        $this->assertEquals($uuid, $contact->id());
        $this->assertEquals('New Contact Updated', $contact->name);
        $this->assertEquals('Second Name Contact Updated', $contact->secondName);
        $this->assertEquals('16123456787', $contact->number);
        $this->assertEquals('testeupdated@teste.com', $contact->email);
    }

    public function testExpectionName()
    {
        $this->expectException(EntityValidationException::class);

        new Contact(
            userId: Uuid::uuid4()->toString(),
            name: 'Ab',
            secondName: 'Second Name Contact',
            number: '123456789',
            email: '',
        );
    }
}