<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Model\Transactional\Jembatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JembatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'status' => 'false',
            'data' => []
        ];
        $jembatan = new Jembatan();
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $laporan = $jembatan->where('uptd',$uptd_id);
        }
        $jembatan = $jembatan->get();

        $ruasJalan = DB::table('master_ruas_jalan');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('uptd_id',$uptd_id);
        }
        $ruasJalan = $ruasJalan->get();

        $sup = DB::table('utils_sup');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $sup = $sup->where('uptd_id',$uptd_id);
        }
        $sup = $sup->get();
        
        return view('admin.master.jembatan.index', compact('jembatan', 'ruasJalan', 'sup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jembatan = $request->except('_token','foto');

        if($request->foto != null){
            $path = 'jembatan/'.Str::snake(date("YmdHis").' '.$request->foto->getClientOriginalName());
            $request->foto->storeAs('public/',$path);
            $jembatan ['foto'] = $path;
        }
        if(Auth::user()->internalRole->uptd){
            $jembatan['uptd_id'] = Auth::user()->internalRole->uptd;
        }else {
            $jembatan['uptd_id'] = "0";
        }
        DB::table('master_jembatan')->insert($jembatan);

        $color = "success";
        $msg = "Berhasil Menambah Data Jembatan";
        return back()->with(compact('color','msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {        
        $jembatan = DB::table('master_jembatan');
        $old = $jembatan->where('id',$id);
        $old->first()->foto ?? Storage::delete('public/'.$old->first()->foto);

        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Jembatan";
        return redirect(route('getMasterJembatan'))->with(compact('color','msg'));
    }
}
