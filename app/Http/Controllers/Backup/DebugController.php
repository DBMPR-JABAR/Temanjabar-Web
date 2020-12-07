<?php

namespace App\Http\Controllers\Backup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebugController extends Controller
{
    public function index()
    {
        $jembatan = DB::table('master_jembatan');

        if($uptd = uptdAccess(1, 'jembatan')){
            $jembatan = $jembatan->whereIn('uptd',$uptd);
        }

        $jembatan = $jembatan->get();
        // $access = hasAccess(1, "pembangunan", "view");
        dd($jembatan);
    }
}
