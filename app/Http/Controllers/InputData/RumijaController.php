<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RumijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rumija = DB::table('rumija')
        ->get();
        return view('admin.input_data.rumija.index',compact('rumija'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uptd = DB::table('landing_uptd')->get();
        $ruas_jalan = DB::table('master_ruas_jalan')->get();
        $kab_kota = DB::table('indonesia_cities')->get();
        $action = 'store';
        return view('admin.input_data.rumija.insert',compact('uptd','ruas_jalan','kab_kota','action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('rumija')->insert($request->except('_token'));
        $color = "success";
        $msg = "Berhasil Menambah Data Rumija";
        return redirect(route('rumija.index'))->with(compact('color', 'msg'));
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
        $uptd = DB::table('landing_uptd')->get();
        $rumija = DB::table('rumija')->where('id',$id)->first();
        $ruas_jalan = DB::table('master_ruas_jalan')->get();
        $kab_kota = DB::table('indonesia_cities')->get();
        $action = 'update';
        return view('admin.input_data.rumija.insert',compact('uptd','rumija','ruas_jalan','kab_kota','action'));

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
        DB::table('rumija')->where('id',$id)->update($request->except('_token','_method'));
        $color = "success";
        $msg = "Berhasil Memperbaharui Data Rumija";
        return redirect(route('rumija.index'))->with(compact('color', 'msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('rumija')->where('id',$id)->delete();
        $color = "success";
        $msg = "Berhasil Memnghapus Data Rumija";
        return redirect(route('rumija.index'))->with(compact('color', 'msg'));
    }
}
