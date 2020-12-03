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

        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $laporan = $ruasJalan->where('UPTD', $uptd_id);
        }
        $ruasJalan = $ruasJalan->get();
        $uptd = $uptd->get();
        return view('admin.master.ruas_jalan.index', compact('ruasJalan', 'uptd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //
        $ruasJalan = $req->except('_token', 'gambar');
        // $ruasJalan['slug'] = Str::slug($req->nama, '');

        // if ($req->gambar != null) {
        //     $path = 'landing/ruasJalan/' . Str::snake(date("YmdHis") . ' ' . $req->gambar->getClientOriginalName());
        //     $req->gambar->storeAs('public/', $path);
        //     $ruasJalan['gambar'] = $path;
        // }

        // if ($req->session()->has('name'))
        $ruasJalan['created_by'] = Auth::user()->id;
        $ruasJalan['created_date'] = date("YmdHis");

        DB::table('master_ruas_jalan')->insert($ruasJalan);

        $color = "success";
        $msg = "Berhasil Menambah Data Ruas Jalan";
        return back()->with(compact('color', 'msg'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $ruasJalan = DB::table('master_ruas_jalan')->where('id', $id)->first();
        return view('admin.master.ruas_jalan.edit', compact('ruasJalan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        //
        $ruasJalan = $req->except('_token', 'gambar', 'id');
        // $ruasJalan['slug'] = Str::slug($req->nama, '');
        $ruasJalan['updated_by'] = Auth::user()->id;
        $ruasJalan['updated_date'] = date("YmdHis");

        $old = DB::table('master_ruas_jalan')->where('id', $req->id)->first();

        // if ($req->gambar != null) {
        //     $old->gambar ?? Storage::delete('public/' . $old->gambar);

        //     $path = 'landing/ruas$ruasJalan/' . Str::snake(date("YmdHis") . ' ' . $req->gambar->getClientOriginalName());
        //     $req->gambar->storeAs('public/', $path);
        //     $ruasJalan['gambar'] = $path;
        // }

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
