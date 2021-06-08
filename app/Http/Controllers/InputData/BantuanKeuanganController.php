<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BantuanKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankeu = DB::table('bankeu')->get();
        return view('admin.input_data.bankeu.index', compact('bankeu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = DB::table('master_kategori_paket')->get();
        $penyedia_jasa = DB::connection('talikuat')->table('master_penyedia_jasa')->get();
        $konsultan = DB::connection('talikuat')->table('master_konsultan')->get();
        $ppk = DB::connection('talikuat')->table('master_ppk')->get();
        $action = 'store';
        return view('admin.input_data.bankeu.insert', compact('action','kategori', 'penyedia_jasa', 'konsultan', 'ppk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bankeu = $request->except(["_token"]);
        $bankeu["created_by"] = Auth::user()->id;
        $bankeu['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('bankeu')->insert($bankeu);

        $color = "success";
        $msg = "Berhasil Menambah Data Bantuan Keuangan";
        return redirect(route('bankeu.index'))->with(compact('color', 'msg'));
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
        $kategori = DB::table('master_kategori_paket')->get();
        $penyedia_jasa = DB::connection('talikuat')->table('master_penyedia_jasa')->get();
        $konsultan = DB::connection('talikuat')->table('master_konsultan')->get();
        $bankeu = DB::table('bankeu')->where('id', $id)->first();
        $ppk = DB::connection('talikuat')->table('master_ppk')->get();
        $action = 'update';
        return view('admin.input_data.bankeu.insert', compact('action','bankeu','kategori', 'penyedia_jasa', 'konsultan', 'ppk'));
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
        $bankeu = $request->except(["_token", "_method"]);
        $bankeu["updated_by"] = Auth::user()->id;
        $bankeu['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('bankeu')->where('id', $id)->update($bankeu);

        $color = "success";
        $msg = "Berhasil Mengubah Data Bantuan Keuangan";
        return redirect(route('bankeu.index'))->with(compact('color', 'msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temp = DB::table('bankeu')->where('id', $id)->delete();
        $color = "success";
        $msg = "Berhasil Menghapus Data Bantuan Keuangan";
        return redirect(route('bankeu.index'))->with(compact('color', 'msg'));
    }
}
