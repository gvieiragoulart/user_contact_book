<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'Custom message exception');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('Custom message exception', $th->getMessage());
        }
    }

    public function testStrMaxLenght()
    {
        try {
            $value = '1234567890123456789012345678901234567890123456789012345678901234567890';
            DomainValidation::strMaxLenght($value, 50, 'Custom message exception');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('Custom message exception', $th->getMessage());
        }
    }

    public function testStrMinLenght()
    {
        try {
            $value = 'ab';
            DomainValidation::strMinLenght($value, 3, 'Custom message exception');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('Custom message exception', $th->getMessage());
        }
    }

    public function testStrCanNullAndMaxLenght()
    {
        try {
            $value = '';
            DomainValidation::strCanNullAndMaxLenght($value, 50, 'Custom message exception');

            $this->assertTrue(true);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('Custom message exception', $th->getMessage());
        }
    }
}