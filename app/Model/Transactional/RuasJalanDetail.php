<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class RuasJalanDetail extends Model
{
    //
    protected $table = "master_ruas_jalan_detail";
    protected $hidden = [
        'id'
    ];
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'id_ruas_jalan','id_ruas_jalan')->with('pekerjaan_pemeliharaan');
    }
    

}
