<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanDetailPeralatan extends Model
{
    use HasFactory;
    protected $table = "kemandoran_detail_peralatan";
    protected $guarded = [];
    public function pemeliharaan()
    {
        return $this->belongsTo('App\Model\Transactional\PekerjaanPemeliharaan', 'id_pek','id_pek');
    }
}
