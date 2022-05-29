<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class UPTD extends Model
{
    protected $table = "landing_uptd";
    
    public function library_sup()
    {
        return $this->hasMany('App\Model\Transactional\SUP', 'uptd_id');
    }
    public function library_pemeliharaan()
    {
        return $this->hasMany('App\Model\Transactional\PekerjaanPemeliharaan', 'uptd_id')->where('is_deleted', '!=', 1);
    }
    public function library_ruas()
    {
        return $this->hasMany('App\Model\Transactional\RuasJalan', 'uptd_id');
    }
    public function library_kota()
    {
        return $this->hasMany('App\Model\Transactional\Kota', 'uptd_id');
    }
    public function kota()
    {
        return $this->hasMany('App\Model\Transactional\Kota', 'uptd_id')->where('kategori',1);
    }
    public function kabupaten()
    {
        return $this->hasMany('App\Model\Transactional\Kota', 'uptd_id')->where('kategori',2);
    }

    public function lubang_sisa()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangSurveiDetail', 'uptd_id')->whereNull('status');
    }
    public function lubang_perencanaan()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangSurveiDetail', 'uptd_id')->where('status','Perencanaan');
    }
    public function lubang_penanganan()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringLubangSurveiDetail', 'uptd_id')->where('status','Selesai');
    }
    public function lubang_potensi()
    {
        return $this->hasMany('App\Model\Transactional\MonitoringPotensiLubangSurveiDetail', 'uptd_id');
    }
}
