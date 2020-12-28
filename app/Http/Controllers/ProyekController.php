<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProyekController extends Controller
{
    public function getKendaliKontrak()
    {
        $finishquery = DB::connection('dwh')->table('vw_uptd_trx_rekap_proyek_kontrak');
        // $finishquery->whereIn('TANGGAL', function ($querySubTanggal) {
        //     $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('vw_uptd_trx_rekap_proyek_kontrak');
        // });

        $criticalquery = clone $finishquery;
        $onprogressquery = clone $finishquery;

        $criticalCount = $criticalquery->whereRaw('BINARY STATUS_PROYEK = "CRITICAL CONTRACT"')->count();
        $onprogressCount = $onprogressquery->whereRaw('BINARY STATUS_PROYEK = "ON PROGRESS"')->count();
        $finishCount = $finishquery->whereRaw('BINARY STATUS_PROYEK = "FINISH"')->count();

        return view('admin.monitoring.proyek-kontrak',
            [   'countCritical' => $criticalCount,
                'countOnProgress' => $onprogressCount,
                'countFinish' => $finishCount,
                'today' => date('Y-m-d'),
                'anggaranData' => ""
            ]);
    }

    public function getKendaliKontrakProgress(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = ($request->has('tahun')) ? $request->tahun : '';
        $uptd = ($request->has('uptd')) ? $request->uptd : '';
        $kegiatan = ($request->has('kegiatan')) ? $request->kegiatan : '';

        return view('admin.monitoring.proyek-kontrak-progress',compact('bulan','tahun','uptd','kegiatan'));
    }

    public function getProyekKontrakAPI(Request $request)
    {
        $kontrak = DB::connection('dwh')->table('vw_uptd_trx_proyek_kontrak');

        if ($request->uptd != "") $kontrak = $kontrak->where('UPTD', '=', $request->uptd);
        if ($request->tahun != "") $kontrak = $kontrak->where('TAHUN', '=', $request->tahun);
        if ($request->kegiatan != "") $kontrak = $kontrak->where('NAMA_KEGIATAN', 'LIKE', "%$request->kegiatan%");

        $dataAll['BULAN'] = [];
        $dataAll['RENCANA'] = [];
        $dataAll['REALISASI'] = [];

        foreach ($kontrak->get() as $data) {
            array_push($dataAll['BULAN'],$data->BULAN);
            array_push($dataAll['RENCANA'],$data->PROGRESS_FISIK_RENCANA_KUMULATIF);
            array_push($dataAll['REALISASI'],$data->PROGRESS_FISIK_REALISASI_KUMULATIF);
        }

        return response()->json(["data" => $dataAll], 200);
    }

    public function getProgressProyekKontrakAPI(Request $request)
    {
        $listProyekKontrak = DB::connection('dwh')->table('vw_uptd_trx_rekap_proyek_kontrak');

        if ($request->tahun != "") $listProyekKontrak = $listProyekKontrak->whereYear('TANGGAL', '=', $request->tahun);
        if ($request->uptd != "") $listProyekKontrak = $listProyekKontrak->where('UPTD', '=', $request->uptd);
        if ($request->kegiatan != "") $listProyekKontrak = $listProyekKontrak->where('NAMA_KEGIATAN', 'LIKE', "%$request->kegiatan%");
        if ($request->dateFrom != "") $listProyekKontrak = $listProyekKontrak->where('TANGGAL', '>=',date_create_from_format("Y-m-d",$request->dateFrom));
        if ($request->dateTo != "") $listProyekKontrak = $listProyekKontrak->where('TANGGAL', '<=', date_create_from_format("Y-m-d",$request->dateTo));

        $listProyekKontrak = $listProyekKontrak->get();

        $proyekKontrak = [];
        foreach ($listProyekKontrak as $proyek) {
            $date_from = Carbon::parse($proyek->DATE_FROM);
            $date_to = Carbon::parse($proyek->DATE_TO);

            $ProyekKontrakData = [
                "colors" => ["#f2f4f5"],
                "name" => $proyek->NAMA_KEGIATAN,
                "data" => [
                    [
                        "id" => "".$proyek->ID,
                        "name" => $proyek->NAMA_KEGIATAN,
                        "jenis" => $proyek->JENIS_PEKERJAAN,
                        "owner" => $proyek->PENYEDIA_JASA
                    ],
                    [
                        "id" => "Rencana ".$proyek->ID,
                        "name" => "Rencana",
                        "parent" => "".$proyek->ID,
                        "start" => $date_from->getPreciseTimestamp(3),
                        "end" => $date_to->getPreciseTimestamp(3),
                        "jenis" => $proyek->JENIS_PEKERJAAN,
                        "owner" => $proyek->PENYEDIA_JASA,
                        "completed" => [
                            "fill" => "#7CB5EC",
                            "amount" => (!empty($proyek->PROGRESS_FISIK_RENCANA_KUMULATIF) ? ($proyek->PROGRESS_FISIK_RENCANA_KUMULATIF * 0.01) : 0)
                        ]
                    ],
                    [
                        "id" => "Realisasi ".$proyek->ID,
                        "name" => "Realisasi",
                        "parent" => $proyek->ID,
                        "start" => $date_from->getPreciseTimestamp(3),
                        "end" => $date_to->getPreciseTimestamp(3),
                        "jenis" => $proyek->JENIS_PEKERJAAN,
                        "owner" => $proyek->PENYEDIA_JASA,
                        "completed" => [
                            "fill" => "#7CB5EC",
                            "amount" => (!empty($proyek->PROGRESS_FISIK_REALISASI_KUMULATIF) ? ($proyek->PROGRESS_FISIK_REALISASI_KUMULATIF * 0.01) : 0)
                        ]
                    ],
                    [
                        "name"  => "<span style='font-size:1em; font-weight:bold'>Deviasi = ".$proyek->DEVIASI_PROGRESS_FISIK."</span>",
                        "parent" => $proyek->ID,
                    ]
                ]
            ];
            array_push($proyekKontrak, $ProyekKontrakData);
        }
        return response()->json(["data" => $proyekKontrak], 200);
    }

    public function getTargetRealisasiAPI(Request $request)
    {
        $uptdList = DB::connection('dwh')->table('TBL_XLS_REKAP_TARGET_REALISASI_KEUANGAN');

        if ($request->uptd != "") $uptdList = $uptdList->where('UPTD', '=', $request->uptd);
        if ($request->tahun != "") $uptdList = $uptdList->whereYear('TAHUN', '=', $request->tahun);

        $dataAll = [];


        foreach ($uptdList->get() as $data) {
            $dataArr = [$data->JANUARI, $data->FEBRUARI, $data->MARET, $data->APRIL, $data->MEI,
                        $data->JUNI, $data->JULI, $data->AGUSTUS, $data->SEPTEMBER, $data->OKTOBER,
                        $data->NOVEMBER, $data->DESEMBER];
            $dataAll[$data->JUDUL][$data->SUB] = $dataArr;
        }

        return response()->json(["data" => $dataAll], 200);
    }
}
