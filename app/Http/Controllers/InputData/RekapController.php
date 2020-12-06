<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
// use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RekapController extends Controller
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
        $rekap = DB::table('rekap');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $laporan = $rekap->where('UPTD',$uptd_id);
        }
        $rekap = $rekap->get();
        return view('admin.input.rekap.index', compact('rekap'));
    }


     public function getData()
    {
        $rekap = DB::table('rekap');
        $rekap = $rekap->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'rekap.ruas_jalan')->select('rekap.*', 'master_ruas_jalan.nama_ruas_jalan');
        // print_r(Auth::user()->internalRole->uptd);
        if (Auth::user()->internalRole->uptd) {
            $rekap = $rekap->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $rekap = $rekap->where('is_deleted',0)->get();

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

        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();


        $mandor = DB::table('users')->where('user_role.id',19);
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        $mandor = $mandor->get();

        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.rekap.index',compact('rekap','ruas_jalan','sup','uptd','mandor','jenis'));
    }
    public function editData($id)
    {
        $pekerjaan = DB::table('rekap')->where('id_pek',$id)->first();
        $ruas_jalan = DB::table('master_ruas_jalan');
         if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id',Auth::user()->internalRole->uptd);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id',Auth::user()->internalRole->uptd);
        }

        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();


        $mandor = DB::table('users')->where('user_role.id',19);
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        $mandor = $mandor->get();

        $sup = $sup->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.rekap.edit',compact('pekerjaan','ruas_jalan','sup','uptd','jenis','mandor'));
    }
    public function createData(Request $req)
    {
        $pekerjaan = $req->except(['_token']);
        // $pekerjaan['slug'] = Str::slug($req->nama, '');
        if($req->foto_awal != null){
            $path = Str::snake(date("YmdHis").' '.$req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['foto_awal'] = $path;
        }
        if($req->foto_sedang != null){
            $path = Str::snake(date("YmdHis").' '.$req->foto_sedang->getClientOriginalName());
            $req->foto_sedang->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['foto_sedang'] = $path;
        }
        if($req->foto_akhir != null){
            $path = Str::snake(date("YmdHis").' '.$req->foto_akhir->getClientOriginalName());
            $req->foto_akhir->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['foto_akhir'] = $path;
        }
        if($req->video != null){
            $path = Str::snake(date("YmdHis").' '.$req->video->getClientOriginalName());
            $req->video->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['video'] = $path;
        }
        $row = DB::table('rekap')->select('id_pek')->orderByDesc('id_pek')->limit(1)->first();

        $pekerjaan['uptd_id'] = $req->uptd_id==''?0:$req->uptd_id;
        $pekerjaan['tglreal'] = date('Y-m-d H:i:s');
        $pekerjaan['is_deleted'] = 0;
        $nomor=intval(substr($row->id_pek,strlen('CK-')))+1;
        $pekerjaan['id_pek'] = 'CK-'.str_pad($nomor,6,"0",STR_PAD_LEFT);

        DB::table('rekap')->insert($pekerjaan);

        $color = "success";
        $msg = "Berhasil Menambah Data Rawan Bencana";
        return back()->with(compact('color','msg'));
    }
    public function updateData(Request $req)
    {
        $pekerjaan = $req->except('_token','id_pek');
        $pekerjaan['uptd_id'] = $req->uptd_id==''?0:$req->uptd_id;

        $old = DB::table('rekap')->where('id_pek',$req->id_pek)->first();
         if($req->foto_awal != null){
            $old->foto_awal ?? Storage::delete('public/pekerjaan/'.$old->foto_awal);

            $path = Str::snake(date("YmdHis").' '.$req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['foto_awal'] = $path;
        }
        if($req->foto_sedang != null){
            $old->foto_sedang ?? Storage::delete('public/pekerjaan/'.$old->foto_sedang);

            $path = Str::snake(date("YmdHis").' '.$req->foto_sedang->getClientOriginalName());
            $req->foto_sedang->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['foto_sedang'] = $path;
        }
        if($req->foto_akhir != null){
            $old->foto_akhir ?? Storage::delete('public/pekerjaan/'.$old->foto_akhir);

            $path = Str::snake(date("YmdHis").' '.$req->foto_akhir->getClientOriginalName());
            $req->foto_akhir->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['foto_akhir'] = $path;
        }
        if($req->video != null){
            $old->video ?? Storage::delete('public/pekerjaan/'.$old->video);

            $path = Str::snake(date("YmdHis").' '.$req->video->getClientOriginalName());
            $req->video->storeAs('public/pekerjaan/',$path);
            $pekerjaan ['video'] = $path;
        }

        DB::table('rekap')->where('id_pek',$req->id_pek)->update($pekerjaan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Rawan Bencana";
        return redirect(route('getDataPekerjaan'))->with(compact('color','msg'));
    }
    public function deleteData($id)
    {
        // $temp = DB::table('rekap')->where('id',$id)->first();
        $param['is_deleted']=1;
        $old = DB::table('rekap')->where('id_pek',$id)->update($param);

        $color = "success";
        $msg = "Berhasil Menghapus Data Pekerjaan";
        return redirect(route('getDataPekerjaan'))->with(compact('color','msg'));
    }
}
