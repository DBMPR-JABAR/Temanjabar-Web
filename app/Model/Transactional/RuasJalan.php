<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RuasJalan extends Model
{
    protected $table = "master_ruas_jalan";
    protected $hidden = ['pivot'];
    
    public function uptd()
    {
        return $this->belongsTo('App\Model\Transactional\UPTD', 'uptd_id');
    }

    public function users()
    {
        // return $this->belongsToMany('App\User','user_id');
        return $this->belongsToMany('App\User','user_master_ruas_jalan','user_id','master_ruas_jalan_id');
    }
    public function geo_prov()
    {
        return $this->hasOne('App\Transactional\RuasJalanProvinsi', 'id_ruas_jalan','id_ruas_jalan');
    }
    public function pekerjaan_pemeliharaan()
    {
        // return $this->belongsToMany('App\User','user_id');
        return $this->hasMany('App\Model\Transactional\PekerjaanPemeliharaan','ruas_jalan_id','id_ruas_jalan')->whereBetween('tanggal', [Carbon::now()->subDays(2)->toDateString(), Carbon::now()->toDateString()]);
    }
    public function data_sup()
    {
        return $this->belongsTo('App\Model\Transactional\SUP', 'kd_sppjj','kd_sup');
    }
    public function data_kota()
    {
        return $this->belongsTo('App\Model\Transactional\Kota', 'kota_id');
    }

}
