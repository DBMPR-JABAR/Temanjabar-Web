<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Model\DWH\RuasJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RuasJalanController extends Controller
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

        $ruasJalan = DB::table('master_ruas_jalan');
        $uptd = DB::table('landing_uptd');
        $sup = DB::table('utils_sup');
        $ruasJalan = $ruasJalan->leftJoin('utils_sup', 'utils_sup.id', '=', 'master_ruas_jalan.sup')->select('master_ruas_jalan.*', 'utils_sup.name as supName');

        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('master_ruas_jalan.uptd_id', $uptd_id);
            $sup = $sup->where('uptd_id', $uptd_id);
            $uptd = $uptd->where('slug', Auth::user()->internalRole->uptd);
        }
        $ruasJalan = $ruasJalan->get();
        $uptd = $uptd->get();
        $sup = $sup->get();
        return view('admin.master.ruas_jalan.index', compact('ruasJalan', 'uptd', 'sup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $ruasJalan = $req->except('_token', 'gambar');
        $ruasJalan['created_by'] = Auth::user()->id;
        $ruasJalan['created_date'] = date("YmdHis");

        DB::table('master_ruas_jalan')->insert($ruasJalan);

        $color = "success";
        $msg = "Berhasil Menambah Data Ruas Jalan";
        return back()->with(compact('color', 'msg'));
    }

    public function edit($id)
    {
        $ruasJalan = DB::table('master_ruas_jalan')->where('id', $id)->first();
        $sup = DB::table('utils_sup');
        $uptd = DB::table('landing_uptd');

        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $sup = $sup->where('uptd_id', $uptd_id);
            $uptd = $uptd->where('slug', Auth::user()->internalRole->uptd);
        }

        $uptd = $uptd->get();
        $sup = $sup->get();

        return view('admin.master.ruas_jalan.edit', compact('ruasJalan', 'sup', 'uptd'));
    }

    public function update(Request $req)
    {
        //
        $ruasJalan = $req->except('_token', 'gambar', 'id');
        // $ruasJalan['slug'] = Str::slug($req->nama, '');
        $ruasJalan['updated_by'] = Auth::user()->id;
        $ruasJalan['updated_date'] = date("YmdHis");

        $old = DB::table('master_ruas_jalan')->where('id', $req->id)->first();

        DB::table('master_ruas_jalan')->where('id', $req->id)->update($ruasJalan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Ruas Jalan";
        return redirect(route('getMasterRuasJalan'))->with(compact('color', 'msg'));
    }

    public function delete($id)
    {
        $ruasJalan = DB::table('master_ruas_jalan');
        $old = $ruasJalan->where('id', $id);

        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Ruas Jalan";
        return redirect(route('getMasterRuasJalan'))->with(compact('color', 'msg'));
    }
}
