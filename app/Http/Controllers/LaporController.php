<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $response = [
        //     'status' => 'false',
        //     'data' => []
        // ]; 
        // $rawanbencana = new RawanBencana();
        // if(Auth::user()->internalRole->uptd){
        //     $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
        //     $laporan = $rawanbencana->where('UPTD',$uptd_id);
        // }
        // $rawanbencana = $rawanbencana->get();
        // return view('admin.master.rawanbencana.index', compact('rawanbencana'));
    }

    public function create(){
        $ruasJalan = DB::table('master_ruas_jalan');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('uptd_id',$uptd_id);
        }
        $ruasJalan = $ruasJalan->get();
        
        $uptd = DB::table('landing_uptd')->get();

        return view('admin.lapor.add', compact('ruasJalan', 'uptd'));
    }

    
    public function store(Request $request)
    {
        $lapor = $request->except('_token','foto');

        if($request->foto != null){
            $path = 'lapor/'.Str::snake(date("YmdHis").' '.$request->foto->getClientOriginalName());
            $request->foto->storeAs('public/',$path);
            $lapor ['foto_awal'] = $path;
        }
        $lapor['status'] = 'menunggu';
        DB::table('aduan')->insert($lapor);

        $color = "success";
        $msg = "Berhasil Menambah Data Lapor";
        return back()->with(compact('color','msg'));
    }
}
