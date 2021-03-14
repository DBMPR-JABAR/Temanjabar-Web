<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressMingguanController extends Controller
{
    public function getProggressMingguan()
    {
        $jadwal = DB::connection('talikuat')->table('jadual');
        $progress_harian = $jadwal->rightJoin('detail_jadual', 'detail_jadual.id_jadual', '=', 'jadual.id')
            ->select('waktu_pelaksanaan', 'kegiatan', 'nama_penyedia', 'tgl', 'nilai', 'jadual.volume')
            ->get();
        return view('admin.monitoring.progress_mingguan.index', compact('jadwal', 'progress_harian'));
    }
}
