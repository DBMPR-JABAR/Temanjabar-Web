<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProyekController extends Controller
{
    public function getProyekKontrak()
    {
        $finishquery = DB::connection('dwh')->table('vw_uptd_trx_proyek_kontrak')
            ->select('NAMA_PAKET', 'TANGGAL', 'PENYEDIA_JASA', 'KEGIATAN', 'RUAS_JALAN', 'LOKASI', 'RENCANA', 'REALISASI', 'DEVIASI', 'JENIS_PEKERJAAN', 'UPTD','STATUS_PROYEK');
        // $finishquery->whereIn('TANGGAL', function ($querySubTanggal) {
        //     $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('vw_uptd_trx_proyek_kontrak');
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

    public function getProyekKontrakAPI(Request $request)
    {
        $listProyekKontrak = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN as A')
            ->select(DB::raw('(SELECT MIN(TANGGAL)  FROM TBL_UPTD_TRX_PROGRESS_MINGGUAN WHERE NAMA_PAKET = A.NAMA_PAKET)  as DATE_FROM'),
                     DB::raw('(SELECT MAX(TANGGAL)  FROM TBL_UPTD_TRX_PROGRESS_MINGGUAN WHERE NAMA_PAKET =  A.NAMA_PAKET ) as DATE_TO'),
                             'A.ID', 'A.NAMA_PAKET', 'A.TANGGAL', 'A.PENYEDIA_JASA', 'A.KEGIATAN', 'A.RUAS_JALAN', 'A.LOKASI', 'A.RENCANA', 'A.REALISASI', 'A.DEVIASI', 'A.JENIS_PEKERJAAN', 'A.UPTD');
        if ($request->tahun != "") $listProyekKontrak = $listProyekKontrak->whereYear('TANGGAL', '=', $request->tahun);
        if ($request->uptd != "") $listProyekKontrak = $listProyekKontrak->where('UPTD', '=', $request->uptd);
        if ($request->kegiatan != "") $listProyekKontrak = $listProyekKontrak->where('KEGIATAN', '=', $request->kegiatan);
        if ($request->dateFrom != "") $listProyekKontrak = $listProyekKontrak->where('TANGGAL', '>=',date_create_from_format("Y-m-d",$request->dateFrom));
        if ($request->dateTo != "") $listProyekKontrak = $listProyekKontrak->where('TANGGAL', '<=', date_create_from_format("Y-m-d",$request->dateFrom));

        $listProyekKontrak = $listProyekKontrak->get();
        $proyekKontrak = [];
        foreach ($listProyekKontrak as $proyek) {
            $date_from = Carbon::parse($proyek->DATE_FROM);
            $date_to = Carbon::parse($proyek->DATE_TO);

            $ProyekKontrakData = [
                "colors" => ["#f2f4f5"],
                "name" => $proyek->NAMA_PAKET,
                "data" => [
                    [
                        "id" => "".$proyek->ID,
                        "name" => $proyek->NAMA_PAKET,
                        "owner" => $proyek->PENYEDIA_JASA
                    ],
                    [
                        "id" => "Rencana ".$proyek->ID,
                        "name" => "Rencana",
                        "parent" => "".$proyek->ID,
                        "start" => $date_from->getPreciseTimestamp(3),
                        "end" => $date_to->getPreciseTimestamp(3),
                        "completed" => [
                            "fill" => "#7CB5EC",
                            "amount" => (!empty($proyek->RENCANA) ? ($proyek->RENCANA / 100) : 0)
                        ]
                    ],
                    [
                        "id" => "Realisasi ".$proyek->ID,
                        "name" => "Realisasi",
                        "parent" => $proyek->ID,
                        "start" => $date_from->getPreciseTimestamp(3),
                        "end" => $date_to->getPreciseTimestamp(3),
                        "completed" => [
                            "fill" => "#7CB5EC",
                            "amount" => (!empty($proyek->REALISASI) ? ($proyek->REALISASI / 100) : 0)
                        ]
                    ],
                    [
                        "name"  => "Deviasi = ".$proyek->DEVIASI,
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
