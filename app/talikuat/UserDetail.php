<?php

namespace App\talikuat;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    // use HasFactory;
    protected $connection= 'mysql';
    protected $table = 'users';
    protected $guarded = [];
}
