<?php

namespace App\talikuat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataumum extends Model
{
    use HasFactory;
    protected $connection = 'talikuat';
    protected $table = 'data_umum';
    protected $guarded = [];

    public function detail()
    {
        $detail = $this->hasOne('App\talikuat\DataUmumDetail', 'data_umum_id')->where('is_active', 1);
        return $detail->with('konsultan')->with('kontraktor')->with('ppk')->with('ruas')->with('dirlap');
    }
    public function jadual()
    {
        $detail = $this->hasOne('App\talikuat\DataUmumDetail', 'data_umum_id')->where('is_active', 1);
        return $detail->with('jadualItems');
    }

    public function list_details()
    {
        return $this->hasMany('App\talikuat\DataUmumDetail', 'data_umum_id');
    }
    public function uptd()
    {
        return $this->belongsTo('App\talikuat\Uptd', 'id_uptd', 'id');
    }
    public function kategori_paket()
    {
        return $this->belongsTo('App\talikuat\KategoriPaket', 'kategori_paket_id', 'id');
    }
    
    public function laporanApproved()
    {
        return $this->hasMany('App\talikuat\Laporan', 'data_umum_id')->where('status', 5);
    }
}
