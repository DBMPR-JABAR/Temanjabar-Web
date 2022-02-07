<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transactional\RuasJalanDetail;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NearbyController extends Controller
{
    //
    public function getNearbyRuas ($lat, $lon){
        // $lat = -6.816729;
        // $lon = 107.555181;
        // return response()->json([
        //     'success'   => true,
        //     'message'   => 'Ruas terdekat',
        //     'data'  => $lat
        // ]);
        $nearby = RuasJalanDetail::select("*",DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(master_ruas_jalan_detail.lat)) 
                * cos(radians(master_ruas_jalan_detail.long) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(master_ruas_jalan_detail.lat))) AS distance"))
            ->groupBy("master_ruas_jalan_detail.id")->orderBy("distance")
        ->take(10)->with('ruas')->first();
        if($nearby){
            return response()->json([
                'success'   => true,
                'message'   => 'Ruas terdekat',
                'data'  => $nearby
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'Ruas tidak ditemukan'
            ]);
        }
    }

}
