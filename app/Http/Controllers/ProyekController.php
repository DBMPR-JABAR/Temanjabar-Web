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
        $listProyekKontrak = DB::connection('dwh')->table('TBL_TALIKUAT_TRX_PROYEK_KONTRAK_PROGRESS_HARIAN as A')
            ->join('TBL_TALIKUAT_TRX_PROYEK_KONTRAK as B', 'B.NMP','=','A.NMP')
            ->select('B.PERIODE_MULAI AS DATE_FROM','B.PERIODE_SELESAI AS DATE_TO',
                     'A.ID', 'A.NMP', 'A.TANGGAL', 'A.RENCANA_VOLUME_HaRIAN', 'A.RENCANA_VOLUME_KUMULATIF', 'A.REALISASI_VOLUME_HARIAN', 'A.REALISASI_VOLUME_KOMULATIF', 'A.PROGRESS_FISIK_RENCANA_BOBOT', 'A.PROGRESS_FISIK_RENCANA_KUMULATIF', 'A.PROGRESS_FISIK_REALISASI_BOBOT', 'A.PROGRESS_FISIK_REALISASI_KUMULATIF', 'A.DEVIASI_PROGRESS_FISIK', 'A.RENCANA_KEUANGAN_HARIAN', 'A.RENCANA_KEUANGAN_KOMULATIF','A.REALISASI_KEUANGAN_HARIAN','A.REALISASI_KEUANGAN_HARIAN1','B.UPTD','B.NAMA_KEGIATAN','B.PENYEDIA_JASA', 'B.JENIS_PEKERJAAN')
            ->whereRaw('A.TANGGAL = B.PERIODE_SELESAI');

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
