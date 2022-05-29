<?php

namespace App\talikuat;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKonsultan extends Model
{
    //use HasFactory;
    protected $connection= 'talikuat';
    protected $table = 'master_konsultan';
    protected $guarded = [];
}
