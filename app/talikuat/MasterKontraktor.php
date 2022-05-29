<?php

namespace App\talikuat;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKontraktor extends Model
{
    // use HasFactory;
    protected $connection= 'talikuat';
    protected $table = 'master_kontraktor';
    protected $guarded = [];
}
