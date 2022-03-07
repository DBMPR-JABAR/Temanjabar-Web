<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringLubangSurveiDetail extends Model
{
    //
    protected $table = "monitoring_lubang_survei_detail";
    protected $guarded = [];
    public function SurveiLubang()
    {
        return $this->belongsTo('App\Model\Transactional\MonitoringLubangSurvei', 'monitoring_lubang_survei_id');
    }
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }
}
