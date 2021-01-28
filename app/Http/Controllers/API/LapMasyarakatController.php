<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LapMasyarakatController extends Controller
{
    //
    public function index()
    {
        $aduan = DB::table('monitoring_laporan_masyarakat')->latest()->paginate(6);
        return response()->json([
            "response" => [
                
                "message"   => "List Data Laporan Kerusakan"
            ],
            "data" => $aduan,
            "status"    => 'success'
        ], 200);

    }
    public function store(Request $request)
    {
        try {
            $rand = rand(100000,999999);
            $kode = "P-".$rand;
            $laporanMasyarakat = new LaporanMasyarakat;
            $laporanMasyarakat->fill($request->except(['gambar']));
            if($request->gambar != null){
                $path = 'laporan_masyarakat/'.date("YmdHis").'_'.$request->gambar->getClientOriginalName();
                $request->gambar->storeAs('public/',$path);
                $laporanMasyarakat['gambar'] = $path;
            }
            $laporanMasyarakat->nomorPengaduan = $kode;
            $laporanMasyarakat->status = 'Submitted';
            $laporanMasyarakat->save();
            $this->response['status'] = 'success';
            $this->response['data']['id'] = $laporanMasyarakat->id;
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
}
