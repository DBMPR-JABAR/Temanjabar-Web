<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringPotensiLubangSurveiDetail extends Model
{
    //
    protected $table = "monitoring_potensi_lubang_survei_detail";
    protected $guarded = [];
    public function SurveiLubang()
    {
        return $this->belongsTo('App\Model\Transactional\MonitoringLubangSurvei', 'monitoring_lubang_survei_id');
    }
    public function ruas()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'ruas_jalan_id','id_ruas_jalan');
    }
    public function DetailRencana()
    {
        return $this->hasOne('App\Model\Transactional\MonitoringLubangRencanaPenangananDetail', 'monitoring_lubang_survei_detail_id');
    }
    public function DetailPenanganan()
    {
        return $this->hasOne('App\Model\Transactional\MonitoringLubangPenangananDetail', 'monitoring_lubang_survei_detail_id');
    }
}
