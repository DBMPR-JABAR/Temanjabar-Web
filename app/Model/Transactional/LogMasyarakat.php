<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class LogMasyarakat extends Model
{
    //
    protected $table = "log_masyarakat";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\UserMasyarakat', 'user_masyarakat_id');
    }
}
