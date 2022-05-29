<?php

namespace App\talikuat;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUmumDetail extends Model
{
    // use HasFactory;
    protected $connection = 'talikuat';
    protected $table = 'data_umum_detail';
    protected $guarded = [];

    public function dataUmum()
    {
        return  $this->belongsTo(DataUmum::class, 'data_umum_id')->with('uptd');
    }

    public function konsultan()
    {
        return $this->belongsTo('App\talikuat\MasterKonsultan', 'konsultan_id');
    }
    public function kontraktor()
    {
        return $this->belongsTo('App\talikuat\MasterKontraktor', 'kontraktor_id');
    }
    public function ppk()
    {
        return $this->belongsTo('App\talikuat\UserDetail', 'ppk_id');
    }
    public function dirlap()
    {
        return $this->belongsTo('App\talikuat\UserDetail', 'dirlap_id');
    }
    public function ruas()
    {
        return $this->hasMany(DataUmumRuas::class, 'data_umum_detail_id');
    }
}
