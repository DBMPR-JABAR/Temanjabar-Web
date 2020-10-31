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

       $proyekkontrak = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN')->get();
       return view('admin.monitoring.dashboard',compact('proyekkontrak'));
    }
    public function getSupData(Request $request){
        $uptd = $request['uptd']; 
          

       $query = DB::connection('dwh')->table('TBL_UPTD_TRX_PEMBANGUNAN')->select('SUP','UPTD');
        
       for($i=0;$i<count($uptd);$i++){   
        $query->orWhere('UPTD', '=', $uptd[$i]);
    }
    
        $queryUPTD = 
 
    //}
    $supData['data']['uptd'] =  $uptd;
    $supData['data']['spp'] =  $query->distinct()->get();
        return response()->json($supData);
        // return view('admin.monitoring.uptd-sup',compact('supData'));

    }

     // TODO: Proyek Kontrak
     public function getProyekKontrak()
     {
        $proyekkontrak = DB::connection('dwh')->table('TBL_UPTD_TRX_PROGRESS_MINGGUAN')->get();
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
