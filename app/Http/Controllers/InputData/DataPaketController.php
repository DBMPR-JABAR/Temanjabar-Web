<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
use App\Model\DWH\DataPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataPaketController extends Controller
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

        $dataPaket = DB::table('pembangunan');
        $uptd = DB::table('landing_uptd');
        $sup = DB::table('utils_sup');
        $pekerjaan = DB::table('utils_jenis_pekerjaan');

        if (Auth::user()->internalRole->uptd) {
            if (Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                // $laporan = $ruasJalan->where('UPTD', $uptd_id);
                $sup = $sup->where('uptd_id', $uptd_id);
                $uptd = $uptd->where('slug', Auth::user()->internalRole->uptd);
            }
        }
        $dataPaket = $dataPaket->get();
        $uptd = $uptd->get();
        $sup = $sup->get();
        $pekerjaan = $pekerjaan->get();
        return view('admin.input_data.data_paket.index', compact('dataPaket', 'uptd', 'sup', 'pekerjaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //
        $dataPaket = $req->except('_token', 'gambar');

        DB::table('pembangunan')->insert($dataPaket);

        $color = "success";
        $msg = "Berhasil Menambah Data Ruas Jalan";
        return redirect(route('getIDDataPaket'))->with(compact('color', 'msg'));
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
    public function edit($kode_paket)
    {
        $dataPaket = DB::table('pembangunan')->where('kode_paket', $kode_paket)->first();
        $sup = DB::table('utils_sup');
        $pekerjaan = DB::table('utils_jenis_pekerjaan');
        $uptd = DB::table('landing_uptd');
        $ruasJalan = DB::table('ruas_jalan');

        if (Auth::user()->internalRole->uptd) {
            if (Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $sup = $sup->where('uptd_id', $uptd_id);
            }
        }

        $sup = $sup->get();
        $pekerjaan = $pekerjaan->get();
        $ruasJalan = $ruasJalan->get();
        $uptd = $uptd->get();

        return view('admin.input_data.data_paket.edit', compact('dataPaket', 'pekerjaan', 'sup', 'ruasJalan', 'uptd'));
    }

    public function add()
    {
        $sup = DB::table('utils_sup');
        $pekerjaan = DB::table('utils_jenis_pekerjaan');
        $ruasJalan = DB::table('ruas_jalan');
        $uptd = DB::table('landing_uptd');

        if (Auth::user()->internalRole->uptd) {
            if (Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                // $laporan = $ruasJalan->where('UPTD', $uptd_id);
                $sup = $sup->where('uptd_id', $uptd_id);
                // $uptd = $uptd->where('slug', Auth::user()->internalRole->uptd);
            }
        }
        // $dataPaket = $dataPaket->get();
        // $uptd = $uptd->get();
        $sup = $sup->get();
        $pekerjaan = $pekerjaan->get();
        $ruasJalan = $ruasJalan->get();
        $uptd = $uptd->get();

        return view('admin.input_data.data_paket.add', compact('pekerjaan', 'sup', 'ruasJalan', 'uptd'));
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
        $dataPaket = $req->except('_token', 'gambar', 'id');

        $old = DB::table('pembangunan')->where('kode_paket', $req->kode_paket)->first();

        // if ($req->gambar != null) {
        //     $old->gambar ?? Storage::delete('public/' . $old->gambar);

        //     $path = 'landing/ruas$dataPaket/' . Str::snake(date("YmdHis") . ' ' . $req->gambar->getClientOriginalName());
        //     $req->gambar->storeAs('public/', $path);
        //     $dataPaket['gambar'] = $path;
        // }

        DB::table('pembangunan')->where('kode_paket', $req->kode_paket)->update($dataPaket);

        $color = "success";
        $msg = "Berhasil Mengubah Data Ruas Jalan";
        return redirect(route('getIDDataPaket'))->with(compact('color', 'msg'));
    }

    public function delete($kode_paket)
    {
        $dataPaket = DB::table('pembangunan');
        $old = $dataPaket->where('kode_paket', $kode_paket);

        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Paket";
        return redirect(route('getIDDataPaket'))->with(compact('color', 'msg'));
    }
}
