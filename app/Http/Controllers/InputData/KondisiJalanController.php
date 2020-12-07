<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
use App\Model\DWH\KondisiJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KondisiJalanController extends Controller
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

        $kondisiJalan = DB::table('tbl_uptd_trx_master_kondisi_jalan');
        $uptd = DB::table('landing_uptd');
        $sup = DB::table('utils_sup');


        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $kondisiJalan = $kondisiJalan->where('uptd', $uptd_id);
        }
        $kondisiJalan = $kondisiJalan->get();
        $uptd = $uptd->get();
        $sup = $sup->get();
        return view('admin.input_data.kondisi_jalan.index', compact('kondisiJalan', 'uptd', 'sup'));
    }

    public function create(Request $req)
    {
        //
        $kondisiJalan = $req->except('_token', 'foto_dokumentasi');

        if ($req->foto_dokumentasi != null) {
            $path = 'landing/kondisiJalan/' . Str::snake(date("YmdHis") . ' ' . $req->foto_dokumentasi->getClientOriginalName());
            $req->foto_dokumentasi->storeAs('public/', $path);
            $kondisiJalan['foto_dokumentasi'] = $path;
        }

        $kondisiJalan['created_by'] = Auth::user()->id;
        $kondisiJalan['created_at'] = date("YmdHis");

        DB::table('tbl_uptd_trx_master_kondisi_jalan')->insert($kondisiJalan);

        $color = "success";
        $msg = "Berhasil Menambah Data Kondisi Jalan";
        return redirect(route('getIDKondisiJalan'))->with(compact('color', 'msg'));
    }

    public function edit($id)
    {
        $uptd = DB::table('landing_uptd');
        $kondisiJalan = DB::table('tbl_uptd_trx_master_kondisi_jalan')->where('id', $id)->first();
        $uptd = $uptd->get();

        $ruasJalan = DB::table('master_ruas_jalan');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('uptd_id',$uptd_id);
        }
        $ruasJalan = $ruasJalan->get();

        return view('admin.input_data.kondisi_jalan.edit', compact('kondisiJalan', 'uptd', 'ruasJalan'));
    }

    public function add()
    {

        $uptd = DB::table('landing_uptd');
        $uptd = $uptd->get();

        $ruasJalan = DB::table('master_ruas_jalan');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('uptd_id',$uptd_id);
        }
        $ruasJalan = $ruasJalan->get();

        return view('admin.input_data.kondisi_jalan.add', compact('uptd', 'ruasJalan'));
    }

    public function update(Request $req)
    {
        $kondisiJalan = $req->except('_token', 'foto_dokumentasi', 'id');
        $kondisiJalan['updated_by'] = Auth::user()->id;
        $kondisiJalan['updated_at'] = date("YmdHis");

        $old = DB::table('tbl_uptd_trx_master_kondisi_jalan')->where('id', $req->id)->first();

        if ($req->foto_dokumentasi != null) {
            $old->foto_dokumentasi ?? Storage::delete('public/' . $old->foto_dokumentasi);

            $path = 'landing/kondisiJalan/' . Str::snake(date("YmdHis") . ' ' . $req->foto_dokumentasi->getClientOriginalName());
            $req->foto_dokumentasi->storeAs('public/', $path);
            $kondisiJalan['foto_dokumentasi'] = $path;
        }

        DB::table('tbl_uptd_trx_master_kondisi_jalan')->where('id', $req->id)->update($kondisiJalan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Kondisi Jalan";
        return redirect(route('getIDKondisiJalan'))->with(compact('color', 'msg'));
    }

    public function delete($id)
    {
        $kondisiJalan = DB::table('tbl_uptd_trx_master_kondisi_jalan');
        $old = $kondisiJalan->where('id', $id);

        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Kondisi Jalan";
        return redirect(route('getIDKondisiJalan'))->with(compact('color', 'msg'));
    }
}
