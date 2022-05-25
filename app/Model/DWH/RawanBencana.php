<?php

namespace App\Model\DWH;

use Illuminate\Database\Eloquent\Model;

class RawanBencana extends Model
{
    protected $connection = 'mysql';
    protected $table = 'master_rawan_bencana'; 
    protected $guarded = [];
}
