<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntegrasiTalikuatController extends Controller
{
    public function curva_s()
    {
        $data_umum = DB::connection('talikuat')->table('data_umum')->where('is_deleted','=',null)->get();
        // dd($data_umum);
        return view('admin.talikuat.curva_s', compact('data_umum'));
    }
}
