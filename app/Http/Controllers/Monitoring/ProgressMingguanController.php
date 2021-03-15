<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressMingguanController extends Controller
{
    public function getProggressMingguan(Request $request)
    {
        $request->tahun = 2020;
        $jadwal = DB::connection('talikuat')->table('jadual');
        $progress_harian = $jadwal->rightJoin('detail_jadual', 'detail_jadual.id_jadual', '=', 'jadual.id')
            ->select('waktu_pelaksanaan', 'kegiatan', 'nama_penyedia', 'tgl', 'nilai', 'detail_jadual.volume as volume');
        if ($request->tahun)
            $progress_harian = $progress_harian->where('detail_jadual.tgl', 'like', '%' . $request->tahun . '%')->get();
        else
            $progress_harian = $progress_harian->get();
        $jadwal = DB::connection('talikuat')->table('jadual')->get();
        // dd($jadwal);
        return view('admin.monitoring.progress_mingguan.index', compact('jadwal', 'progress_harian'));
    }
}
