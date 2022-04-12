<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class LaporanMasyarakat extends Model
{
    protected $table = 'monitoring_laporan_masyarakat';
    protected $guarded = [];

    public function uptd()
    {
        return $this->belongsTo('App\Model\Transactional\UPTD', 'uptd_id');
    }
    public function jenis_laporan()
    {
        return $this->belongsTo('App\Model\Transactional\JenisLaporan', 'jenis');
    }
}
