<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
// use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PekerjaanController extends Controller
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
        $rawanbencana = new RawanBencana();
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $laporan = $rawanbencana->where('UPTD',$uptd_id);
        }
        $rawanbencana = $rawanbencana->get();
        return view('admin.master.rawanbencana.index', compact('rawanbencana'));
    }


     public function getData()
    {
        $rawan = DB::table('master_rawan_bencana');
        $rawan = $rawan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'master_rawan_bencana.ruas_jalan')->select('master_rawan_bencana.*', 'master_ruas_jalan.nama_ruas_jalan');
        // print_r(Auth::user()->internalRole->uptd);
        if (Auth::user()->internalRole->uptd) {
            $rawan = $rawan->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $rawan = $rawan->get();
        $ruas = DB::table('master_ruas_jalan')->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.master.rawanbencana.index',compact('rawan','ruas','uptd'));
    }
    public function editData($id)
    {
        $rawan = DB::table('master_rawan_bencana')->where('id',$id)->first();
        $ruas = DB::table('master_ruas_jalan')->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.master.rawanbencana.edit',compact('rawan','ruas','uptd'));
    }
    public function createData(Request $req)
    {
        $rawan = $req->except('_token');
        // $rawan['slug'] = Str::slug($req->nama, '');
        $rawan['uptd_id'] = $req->uptd_id==''?0:$req->uptd_id;

        DB::table('master_rawan_bencana')->insert($rawan);

        $color = "success";
        $msg = "Berhasil Menambah Data Rawan Bencana";
        return back()->with(compact('color','msg'));
    }
    public function updateData(Request $req)
    {
        $rawan = $req->except('_token','id');
        $rawan['uptd_id'] = $req->uptd_id==''?0:$req->uptd_id;

        $old = DB::table('master_rawan_bencana')->where('id',$req->id)->first();

        DB::table('master_rawan_bencana')->where('id',$req->id)->update($rawan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Rawan Bencana";
        return redirect(route('getDataBencana'))->with(compact('color','msg'));
    }
    public function deleteData($id)
    {
        $old = DB::table('master_rawan_bencana')->where('id',$id);
        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Rawan Bencana";
        return redirect(route('getDataBencana'))->with(compact('color','msg'));
    }
}
