<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringLubangPenanganan extends Model
{
    //
    protected $table = "monitoring_lubang_penanganan";
    protected $guarded = [];
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }
    public function PenangananLubangDetail()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangPenangananDetail','monitoring_lubang_penanganan_id')->latest();
    }
}
