<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
// use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgressPekerjaanController extends Controller
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
        $pekerjaan = new ProgressPekerjaan();
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $laporan = $pekerjaan->where('UPTD',$uptd_id);
        }
        $pekerjaan = $pekerjaan->get();
        return view('admin.input.progresskerja.index', compact('pekerjaan'));
    }


     public function getDataProgress()
    {
        $pekerjaan = DB::table('progress_mingguan');
        // $pekerjaan = $pekerjaan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'progress_mingguan.ruas_jalan')->select('progress_mingguan.*', 'master_ruas_jalan.nama_ruas_jalan');
        // print_r(Auth::user()->internalRole->uptd);
        if (Auth::user()->internalRole->uptd) {
            $pekerjaan = $pekerjaan->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $pekerjaan = $pekerjaan->get();

        $ruas_jalan = DB::table('master_ruas_jalan');
         if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
         if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $sup = $sup->get();

        $paket =array();
        $penyedia =array();
        $data2 = DB::table('tbl_uptd_trx_pembangunan');
        if (Auth::user()->internalRole->uptd) {
            $data2 = $data2->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $data2 = $data2->get();
        foreach ($data2 as $val){
            if($val->NAMA_PAKET!=''){
                array_push($paket, $val->NAMA_PAKET);
            }
            if($val->PENYEDIA_JASA!=''){
                array_push($penyedia, $val->PENYEDIA_JASA);
            }
        }

        $jenis = DB::table('utils_jenis_pekerjaan');
        $jenis = $jenis->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.progresskerja.index',compact('jenis','pekerjaan','ruas_jalan','sup','uptd','penyedia','paket'));
    }
   
    public function editDataProgress($id)
    {
        $progress = DB::table('progress_mingguan')->where(array('id'=>$id));
        if (Auth::user()->internalRole->uptd) {
            $progress = $progress->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $progress = $progress->first();


        $ruas_jalan = DB::table('master_ruas_jalan');
         if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
         if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $sup = $sup->get();

        $paket =array();
        $penyedia =array();
        $data2 = DB::table('tbl_uptd_trx_pembangunan');
        if (Auth::user()->internalRole->uptd) {
            $data2 = $data2->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $data2 = $data2->get();
        foreach ($data2 as $val){
            if($val->NAMA_PAKET!=''){
                array_push($paket, $val->NAMA_PAKET);
            }
            if($val->PENYEDIA_JASA!=''){
                array_push($penyedia, $val->PENYEDIA_JASA);
            }
        }

        $jenis = DB::table('utils_jenis_pekerjaan');
        $jenis = $jenis->get();

        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.progresskerja.edit',compact('jenis','progress','ruas_jalan','sup','uptd','penyedia','paket'));
    }

    public function createDataProgress(Request $req)
    {
        $progress = $req->except(['_token']);
        unset($req->_token);
        $progress['deviasi']=0;
        $progress['bayar1']=0;
        $progress['sisa']=0;
        $progress['prosentase']=0;
        $progress['kategori']=null;
        $progress['status']=null;
        // $progress['slug'] = Str::slug($req->nama, '');
        if($req->foto != null){
            $path = Str::snake(date("YmdHis").' '.$req->foto->getClientOriginalName());
            $req->foto->storeAs('public/progresskerja/',$path);
            $progress ['foto'] = $path;
        }
        if($req->video != null){
            $path = Str::snake(date("YmdHis").' '.$req->video->getClientOriginalName());
            $req->video->storeAs('public/progresskerja/',$path);
            $progress ['video'] = $path;
        }

        DB::table('progress_mingguan')->insert($progress);

        $color = "success";
        $msg = "Berhasil Menambah Data Progress Pekerjaan";
        return back()->with(compact('color','msg'));
    }
    public function updateDataProgress(Request $req)
    {
        $progress = $req->except('_token','id');
        $old = DB::table('progress_mingguan')->where('id',$req->id)->first();
        if($req->foto != null){
            $old->foto ?? Storage::delete('public/progresskerja/'.$old->foto);

            $path = Str::snake(date("YmdHis").' '.$req->foto->getClientOriginalName());
            $req->foto->storeAs('public/progresskerja/',$path);
            $progress ['foto'] = $path;
        }

        if($req->video != null){
            $old->video ?? Storage::delete('public/progresskerja/'.$old->video);

            $path = Str::snake(date("YmdHis").' '.$req->video->getClientOriginalName());
            $req->video->storeAs('public/progresskerja/',$path);
            $progress ['video'] = $path;
        }

        DB::table('progress_mingguan')->where('id',$req->id)->update($progress);

        $color = "success";
        $msg = "Berhasil Mengubah Data Progress Pekerjaan";
        return redirect(route('getDataProgress'))->with(compact('color','msg'));
    }
    public function deleteDataProgress($id)
    {
        $old = DB::table('progress_mingguan')->where('id',$id)->first();
        $old->foto ?? Storage::delete('public/progresskerja/'.$old->foto);
        $old->video ?? Storage::delete('public/progresskerja/'.$old->video);

        $temp = DB::table('progress_mingguan')->where('id',$id);
        $temp->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Pekerjaan";
        return redirect(route('getDataProgress'))->with(compact('color','msg'));
    }
}
