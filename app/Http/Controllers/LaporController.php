<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LaporController extends Controller
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

        $aduan = DB::table('aduan');

        if (Auth::user()->internalRole->uptd) {
            if (Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $aduan = $aduan->where('uptd_id', $uptd_id);
            }
        }
        $aduan = $aduan->get();
        return view('admin.lapor.index', compact('aduan'));
    }

    public function create()
    {
        $ruasJalan = DB::table('master_ruas_jalan');
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('uptd_id', $uptd_id);
        }
        $ruasJalan = $ruasJalan->get();

        $uptd = DB::table('landing_uptd')->get();

        return view('admin.lapor.add', compact('ruasJalan', 'uptd'));
    }

    public function edit($id)
    {
        $aduan = DB::table('aduan')->where('id', $id)->first();
        $ruasJalan = DB::table('master_ruas_jalan');
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $ruasJalan = $ruasJalan->where('uptd_id', $uptd_id);
        }

        $ruasJalan = $ruasJalan->get();
        $uptd = DB::table('landing_uptd')->get();

        return view('admin.lapor.edit', compact('aduan', 'ruasJalan', 'uptd'));
    }


    public function store(Request $request)
    {
        $lapor = $request->except('_token', 'foto');

        if ($request->foto != null) {
            $path = 'lapor/' . Str::snake(date("YmdHis") . ' ' . $request->foto->getClientOriginalName());
            $request->foto->storeAs('public/', $path);
            $lapor['foto_awal'] = $path;
        }
        $lapor['status'] = 'menunggu';
        DB::table('aduan')->insert($lapor);

        $color = "success";
        $msg = "Berhasil Menambah Data Lapor";
        return back()->with(compact('color', 'msg'));
    }

    public function update(Request $req)
    {
        //
        $aduan = $req->except('_token', 'foto_awal', 'id');

        $old = DB::table('aduan')->where('id', $req->id)->first();

        if ($req->foto_awal != null) {
            $old->foto_awal ?? Storage::delete('public/' . $old->foto_awal);

            $path = 'landing/' . Str::snake(date("YmdHis") . ' ' . $req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/', $path);
            $aduan['foto_awal'] = $path;
        }

        DB::table('aduan')->where('id', $req->id)->update($aduan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Laporan";
        return redirect(route('getLapor'))->with(compact('color', 'msg'));
    }

    public function delete($id)
    {
        $aduan = DB::table('aduan');
        $old = $aduan->where('id', $id);

        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Laporan";
        return redirect(route('getLapor'))->with(compact('color', 'msg'));
    }
}
