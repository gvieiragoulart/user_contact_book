<?php

namespace Tests\Unit\App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\ModelTestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return ['id', 'user_id', 'name', 'second_name', 'email', 'number'];
    }   

    protected function casts(): array
    {
        return [
            'id'    => 'string',
            'user_id' => 'string',
            'name' => 'string',
            'second_name' => 'string',
            'email' => 'string',
            'number' => 'string'
        ];
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->model()->getIncrementing());
    }
}
