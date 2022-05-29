<?php

namespace App\talikuat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPaket extends Model
{
    use HasFactory;
    protected $connection= 'talikuat';
    protected $table = 'kategori_paket';
    protected $guarded = [];
}
