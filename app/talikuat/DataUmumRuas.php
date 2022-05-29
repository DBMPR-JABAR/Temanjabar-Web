<?php

namespace App\talikuat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUmumRuas extends Model
{
    use HasFactory;
    protected $connection = 'talikuat';
    protected $table = 'data_umum_ruas';
    protected $guarded = [];

    public function detail_ruas()
    {
        return $this->belongsTo('App\talikuat\RuasJalan', 'id_ruas_jalan','id_ruas_jalan');
    }
}
