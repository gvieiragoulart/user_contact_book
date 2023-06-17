<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'user_id',
        'name',
        'second_name',
        'email',
        'number'
    ];

    public $incrementing = false;

    protected $casts = [
        'id'    => 'string',
        'user_id' => 'string',
        'name' => 'string',
        'second_name' => 'string',
        'email' => 'string',
        'number' => 'string'
    ];
}
