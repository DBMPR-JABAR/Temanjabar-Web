<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transactional\Kota;
use Illuminate\Support\Facades\Auth;

class KotaController extends Controller
{
    //
    public function index()
    {
        $kota = Kota::all();
        return view('admin.master.kota.index', compact('kota'));
    }
    public function edit($id)
    {
        $data = Kota::find($id);
        return view('admin.master.kota.form', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'uptd_id'      => 'required',

        ]);

        $uptd_id = $request->uptd_id;
        $sup['name'] = $request->name;
        $sup['kd_sup'] = $request->kd_sup;
        $data = Kota::find($id);
        $data->name = $request->name;

        if(Auth::user() && Auth::user()->internalRole->uptd != null){
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $data->uptd_id = $uptd_id;
        }else
        $data->uptd_id = $request->uptd_id;

        $data->save();

        if($data){
            //redirect dengan pesan sukses
            $color = "success";
            $msg = "Kota Berhasil Diperbaharui!";
            return redirect(route('getMasterKota'))->with(compact('color','msg'));
        }else{
            //redirect dengan pesan error
            $color = "danger";
            $msg = "Data Gagal atau Tidak Ada yang Diperbaharui!";
            return redirect(route('getMasterKota'))->with(compact('color', 'msg'));

        }
    }
}
