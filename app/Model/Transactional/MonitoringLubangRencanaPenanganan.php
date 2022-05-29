<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringLubangRencanaPenanganan extends Model
{
    //
    protected $table = "monitoring_lubang_rencana_penanganan";
    protected $guarded = [];
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }
    public function RencanaPenangananLubangDetail()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangRencanaPenangananDetail','monitoring_lubang_rencana_penanganan_id')->latest();
    }
}
