<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new User();
    }

    public function traits(): array
    {
        return [
            HasApiTokens::class,
            HasFactory::class,
            Notifiable::class,
        ];
    }

    public function fillables(): array
    {
        return [
            'id',
            'name',
            'email',
            'password',
        ];
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->model()->getIncrementing());
    }
}
