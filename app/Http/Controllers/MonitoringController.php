<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\DWH\ProgressMingguan;

class MonitoringController extends Controller
{
    public function getLaporan()
    {
        $laporan = DB::table('monitoring_laporan_masyarakat')->get();
        return view('admin.monitoring.laporan-kerusakan',compact('laporan'));
    }

    public function getMainDashboard()
    {
     //   $category = DB::connection('dwh')->select("");

       $proyekkontrak = DB::table('progress_mingguan')->get();
       return view('admin.monitoring.dashboard');
    }

     // TODO: Proyek Kontrak
     public function getProyekKontrak()
     {
        $proyekkontrak = DB::table('progress_mingguan')->get();
        return view('admin.monitoring.proyek-kontrak',compact('proyekkontrak'));
     }

     public function getProyekDetail($status)
     {
        $proyekdetail = ProgressMingguan::get()->filter(function($item) use ($status) {
            return $item->STATUS_PROYEK === $status;
        });
        return view('admin.monitoring.proyek-kontrak-detail',compact('proyekdetail'));
     }
    
}
