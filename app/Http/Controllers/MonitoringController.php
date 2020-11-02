<?php

namespace App\Http\Controllers;

use App\Model\DWH\ProgressMingguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function getLaporan()
    {
        $laporan = DB::table('monitoring_laporan_masyarakat')->get();
        return view('admin.monitoring.laporan-kerusakan', compact('laporan'));
    }

    public function getMainDashboard()
    {
        //   $category = DB::connection('dwh')->select("");

        $proyekkontrak = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN')->get();
        return view('admin.monitoring.dashboard', compact('proyekkontrak'));
    }
    public function getSupData(Request $request)
    {
        $uptd = $request['uptd'];
        $query = DB::connection('dwh')->table('TBL_UPTD_TRX_PEMBANGUNAN')->select('SUP', 'UPTD');

        for ($i = 0; $i < count($uptd); $i++) {
            $query->orWhere('UPTD', '=', $uptd[$i]);
        }
        $supData['data']['uptd'] = $uptd;
        $supData['data']['spp'] = $query->distinct()->get();
        return response()->json($supData);
    }

    // TODO: Proyek Kontrak
    public function getProyekKontrak()
    {
 
        $query = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN')
            ->select('NAMA_PAKET', 'TANGGAL', 'PENYEDIA_JASA', 'KEGIATAN', 'RUAS_JALAN', 'LOKASI', 'RENCANA', 'REALISASI', 'DEVIASI', 'JENIS_PEKERJAAN', 'UPTD');
        $query->whereIn('TANGGAL', function ($querySubTanggal) {
            $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('TBL_UPTD_TRX_PROGRESS_MINGGUAN')
            ;
        });

        $queryCritical = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN')
            ->select('NAMA_PAKET', 'TANGGAL', 'PENYEDIA_JASA', 'KEGIATAN', 'RUAS_JALAN', 'LOKASI', 'RENCANA', 'REALISASI', 'DEVIASI', 'JENIS_PEKERJAAN', 'UPTD');
        $query->whereIn('TANGGAL', function ($querySubTanggal) {
            $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('TBL_UPTD_TRX_PROGRESS_MINGGUAN');
        });
        $queryOnProgress = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN');
        $query->whereIn('TANGGAL', function ($querySubTanggal) {
            $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('TBL_UPTD_TRX_PROGRESS_MINGGUAN');
        });
        $queryoffProgress = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN');
        $query->whereIn('TANGGAL', function ($querySubTanggal) {
            $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('TBL_UPTD_TRX_PROGRESS_MINGGUAN');
        });

        $queryfinish = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN')
            ->select('NAMA_PAKET', 'TANGGAL', 'PENYEDIA_JASA', 'KEGIATAN', 'RUAS_JALAN', 'LOKASI', 'RENCANA', 'REALISASI', 'DEVIASI', 'JENIS_PEKERJAAN', 'UPTD');
        $query->whereIn('TANGGAL', function ($querySubTanggal) {
            $querySubTanggal->select(DB::raw('MAX(TANGGAL)'))->from('TBL_UPTD_TRX_PROGRESS_MINGGUAN');
        });

        $critical = $queryCritical->where('DEVIASI', '<', -5);
        $onprogress = $queryOnProgress->where('DEVIASI', '>', -5);
        $offProgress = $queryoffProgress->where('DEVIASI', '<', -5);
        $finish = $queryfinish->where('DEVIASI', '=', '0');
        $listProjectContract = $query->get();
        $countCritical = $critical->get()->count();
        $countOnProgress = $onprogress->get()->count();
        $countOffProgress = $offProgress->get()->count();
        $countFinish = $finish->get()->count();
        return view('admin.monitoring.proyek-kontrak',
            ['listProjectContract' => $listProjectContract,
                'countCritical' => $countCritical,
                'countOnProgress' => $countOnProgress,
                'countOffProgress' => $countOffProgress,
                'countFinish' => $countFinish,
            ]);
    }

    public function getProyekDetail($status)
    {
        $proyekdetail = ProgressMingguan::get()->filter(function ($item) use ($status) {
            return $item->STATUS_PROYEK === $status;
        });
        return view('admin.monitoring.proyek-kontrak-detail', compact('proyekdetail'));
    }

}
