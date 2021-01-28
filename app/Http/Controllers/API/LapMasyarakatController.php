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
        $aduan = DB::table('monitoring_laporan_masyarakat')->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Laporan Kerusakan"
            ],
            "data" => $aduan
        ], 200);

        // if($request->has("skip")){
        //     return (KerusakanJalanResource::collection(LaporanMasyarakat::skip($request->skip)->take($request->take)->get())->additional(['status' => 'success']));
        // }
        // return (KerusakanJalanResource::collection(LaporanMasyarakat::all())->additional(['status' => 'success']));
    }
}
