<?php

namespace App\talikuat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $connection = 'talikuat';
    protected $table = 'laporan';
    protected $guarded = [];
}
