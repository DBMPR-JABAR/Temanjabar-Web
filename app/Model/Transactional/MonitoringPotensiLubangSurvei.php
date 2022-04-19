<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringPotensiLubangSurvei extends Model
{
    //
    protected $table = "monitoring_potensi_lubang_survei";
    protected $guarded = [];
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }
    public function SurveiPotensiLubangDetail()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringPotensiLubangSurveiDetail','monitoring_potensi_lubang_survei_id')->latest();
    }
    public function SurveiPotensiLubangDetailExecute()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringPotensiLubangSurveiDetail','monitoring_lubang_survei_id')->whereNull('status')->latest();
    }
}
