<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanDetailMaterial extends Model
{
    use HasFactory;
    protected $table = "bahan_material";
    protected $guarded = [];
    public function pemeliharaan()
    {
        return $this->belongsTo('App\Model\Transactional\PekerjaanPemeliharaan', 'id_pek','id_pek');
    }
}
