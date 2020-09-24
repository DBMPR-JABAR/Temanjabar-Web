<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function getLaporan()
    {
        $laporan = DB::table('laporan')->get();
        return view('admin.monitoring.laporan-kerusakan',compact('laporan'));
    }
}
