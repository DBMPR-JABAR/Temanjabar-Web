<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringLubangSurvei extends Model
{
    //
    protected $table = "monitoring_lubang_survei";
    protected $guarded = [];
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }
    public function SurveiLubangDetail()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangSurveiDetail','monitoring_lubang_survei_id')->latest();
    }
    public function SurveiLubangDetailExecute()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangSurveiDetail','monitoring_lubang_survei_id')->whereNull('status')->latest();
    }
}
