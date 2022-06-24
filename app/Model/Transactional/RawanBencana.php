<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class RawanBencana extends Model
{
    protected $table = "master_rawan_bencana";

    public $timestamps = false;

    public function ruasJalan()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'no_ruas','id_ruas_jalan');
    }

    public function uptd()
    {
        return $this->belongsTo('App\Model\Transactional\UPTD', 'uptd_id');
    }
}
