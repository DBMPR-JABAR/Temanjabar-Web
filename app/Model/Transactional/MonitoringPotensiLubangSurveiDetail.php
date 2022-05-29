<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringPotensiLubangSurveiDetail extends Model
{
    //
    protected $table = "monitoring_potensi_lubang_survei_detail";
    protected $guarded = [];
    public function SurveiPotensiLubang()
    {
        return $this->belongsTo('App\Model\Transactional\MonitoringPotensiLubangSurvei', 'monitoring_potensi_lubang_survei_id');
    }
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }

}
