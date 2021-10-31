<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    protected $table = "survei_kondisi_jalan";
    protected $guarded = [];

    public function ruasJalan() {
        return $this->belongsTo('App\Model\DWH\RuasJalan', 'idruas');
    }

}
