<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class MonitoringLubangPenangananDetail extends Model
{
    //
    protected $table = "monitoring_lubang_penanganan_detail";
    protected $guarded = [];
    public function PenangananLubang()
    {
        return $this->belongsTo('App\Model\Transactional\RuasJalan', 'monitoring_lubang_penanganan_id');
    }
}
