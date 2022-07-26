<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class PekerjaanPemeliharaan extends Model
{
    //
    protected $table = "kemandoran";
    protected $guarded = [];
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'id_ruas_jalan','ruas_jalan_id');
    }
    public function detailPeralatan()
    {
        return $this->hasMany('App\Model\Transactional\PemeliharaanDetailPeralatan', 'id_pek','id_pek');
    }
}
