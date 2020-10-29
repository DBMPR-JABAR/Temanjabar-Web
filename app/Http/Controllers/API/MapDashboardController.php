<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DWH\Pembangunan;
use App\Model\DWH\RuasJalan;
use App\Model\DWH\Kemandoran;
use App\Model\DWH\ProgressMingguan;
use App\Model\DWH\Jembatan;

class MapDashboardController extends Controller
{
    public function filter(Request $req)
    {
        $data = RuasJalan::whereIn('UPTD',$req->uptd)->get();
        return response()->json($data);
    }
}
