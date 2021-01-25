<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveiController extends Controller
{
    public function getCCTV()
    {
        $cctv = DB::connection('dwh')->table("TBL_TMNJABAR_TRX_CCTV")
            ->select('*')->get();
        //dd($cctv);
        return view('admin.monitoring.cctv-command-center', [
            'cctv' => $cctv
        ]);
    }
    public function getRoadroidSKJ($id)
    {
        $surveiKondisiJalan = DB::table('roadroid_trx_survey_kondisi_jalans')->where('id_ruas_jalan', $id)->orderBy('id')->get();
        //dd($surveiKondisiJalan);
        return view('admin.monitoring.roadroid-survei-kondisi-jalan', ['id' => $id, 'surveiKondisiJalan' => $surveiKondisiJalan]);
    }
}
