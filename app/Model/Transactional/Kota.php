<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    //
    protected $table = "master_kota";
    protected $guarded = [];

    public function uptd()
    {
        return $this->belongsTo('App\Model\Transactional\UPTD', 'uptd_id');
    }
}
