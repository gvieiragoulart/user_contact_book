<?php

namespace Tests\Unit\App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Contact();
    }

    public function traits(): array
    {
        return [
            HasFactory::class,
        ];
    }

    public function fillables(): array
    {
        return ['id', 'user_id', 'name', 'second_name', 'email', 'number', 'image_path'];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'name' => 'string',
            'second_name' => 'string',
            'email' => 'string',
            'number' => 'string',
            'image_path' => 'string',
        ];
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->model()->getIncrementing());
    }
}
