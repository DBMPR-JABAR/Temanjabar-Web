<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function getLaporan()
    {
        $laporan = DB::table('monitoring_laporan_masyarakat')->get();
        return view('admin.monitoring.laporan-kerusakan',compact('laporan'));
    }
}
