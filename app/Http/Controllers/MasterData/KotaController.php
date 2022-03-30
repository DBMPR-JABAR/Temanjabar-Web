<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transactional\Kota;

class KotaController extends Controller
{
    //
    public function index()
    {
        $kota = Kota::all();
        return view('admin.master.kota.index', compact('kota'));
    }
}
