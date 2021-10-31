<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class SurveiKerusakan extends Model
{
    protected $table = "survei_kondisi_jalan_kerusakan";
    protected $keyType = 'string';
    protected $guarded = [];
}
