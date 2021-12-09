<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveiController extends Controller
{
    public function __construct()
    {
        $cctv_controll_room = setAccessBuilder('CCTV Control Room', [], ['getCCTV'], [], []);
        $survey_kondisi_jalan = setAccessBuilder('Monitoring Survei Kondisi Jalan', [], ['getRoadDroidSKJ'], [], []);
        $roles = array_merge($cctv_controll_room, $survey_kondisi_jalan);
        foreach ($roles as $role => $permission) {
            $this->middleware($role)->only($permission);
        }
    }

    public function getCCTV()
    {
        $cctv = DB::table("cctv")
            ->select('*')->get();
        //dd($cctv);
        $userUptd = DB::table('user_role')->where('id', Auth::user()->internal_role_id)->first();
        if ($userUptd->uptd == null) {
            $uptd = DB::table('landing_uptd')->get();
        } else {
            $uptd = DB::table('landing_uptd')->where('slug', $userUptd->uptd);
        }
        return view('admin.monitoring.cctv-command-center', [
            'cctv' => $cctv,
            'userUptdList' => $uptd,
        ]);
    }
    public function getRoadroidSKJ($id)
    {
        $surveiKondisiJalan = DB::table('roadroid_trx_survey_kondisi_jalan')->where('id_ruas_jalan', $id)->orderBy('id')->get();
        //dd($surveiKondisiJalan);
        return view('admin.monitoring.roadroid-survei-kondisi-jalan', ['id' => $id, 'surveiKondisiJalan' => $surveiKondisiJalan]);
    }

    public function getKinerjaJalan($idruas)
    {
        $namaJalan = DB::table('master_ruas_jalan')
            ->where('id_ruas_jalan', $idruas)->first()->nama_ruas_jalan;

        $kemantapanjalan = DB::table('survei_kondisi_jalan')
                             ->where('idruas', $idruas)
                             ->orderBy('tgl_survei')
                             ->first();

        $kerusakan = DB::table('survei_kondisi_jalan_kerusakan')
            ->where('idruas', $idruas)
            ->get();

        $kondisi = [
            'SANGAT_BAIK' => $kemantapanjalan->sangat_baik ?? 0,
            'BAIK' => $kemantapanjalan->baik ?? 0,
            'SEDANG' => $kemantapanjalan->sedang ?? 0,
            'JELEK' => $kemantapanjalan->jelek ?? 0,
            'PARAH' => $kemantapanjalan->parah ?? 0,
            'SANGAT_PARAH' => $kemantapanjalan->sangat_parah ?? 0,
            'HANCUR' => $kemantapanjalan->hancur ?? 0,
        ];

        return view('admin.monitoring.survei.detail-kinerja-jalan', compact('kerusakan', 'namaJalan', 'kondisi', 'idruas'));
    }

    public function getKinerjaJalanPrint($idruas)
    {
        $namaJalan = DB::table('master_ruas_jalan')
            ->where('id_ruas_jalan', $idruas)->first()->nama_ruas_jalan;

        $kemantapanjalan = DB::table('survei_kondisi_jalan')->where('idruas', $idruas)->first();

        $kerusakan = DB::table('survei_kondisi_jalan_kerusakan')
            ->where('idruas', $idruas)
            ->get();

        $kondisi = [
            'SANGAT_BAIK' => $kemantapanjalan->sangat_baik ?? 0,
            'BAIK' => $kemantapanjalan->baik ?? 0,
            'SEDANG' => $kemantapanjalan->sedang ?? 0,
            'JELEK' => $kemantapanjalan->jelek ?? 0,
            'PARAH' => $kemantapanjalan->parah ?? 0,
            'SANGAT_PARAH' => $kemantapanjalan->sangat_parah ?? 0,
            'HANCUR' => $kemantapanjalan->hancur ?? 0,
        ];

        return view('admin.monitoring.survei.detail-kinerja-jalan-print', compact('kerusakan', 'namaJalan', 'kondisi'));
    }
}
