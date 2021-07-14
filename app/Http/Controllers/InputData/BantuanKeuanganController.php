<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BantuanKeuanganController extends Controller
{
    public function __construct()
    {
        $roles = setAccessBuilder('Bantuan Keuangan', ['create', 'store'], ['index'], ['edit', 'update'], ['destroy']);
        foreach ($roles as $role => $permission) {
            $this->middleware($role)->only($permission);
        }
    }
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
        $ruas_jalan = DB::table('ruas_jalan_kabupaten_tarung')->select(['*'])->get();
        $kategori = DB::table('master_kategori_paket')->get();
        $penyedia_jasa = DB::connection('talikuat')->table('master_penyedia_jasa')->get();
        $konsultan = DB::connection('talikuat')->table('master_konsultan')->get();
        $ppk = DB::connection('talikuat')->table('master_ppk')->get();
        $action = 'store';
        return view('admin.input_data.bankeu.insert', compact('action', 'ruas_jalan', 'kategori', 'penyedia_jasa', 'konsultan', 'ppk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bankeu = $request->except(["_token", 'progress_old', 'foto', 'foto_1', 'foto_2', 'video']);
        $bankeu["created_by"] = Auth::user()->id;
        $bankeu['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        if ($request->file('foto') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('foto')->getClientOriginalName());
            $request->file('foto')->storeAs('public/', $path);
            $bankeu['foto'] = $path;
        }
        if ($request->file('foto_1') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('foto_1')->getClientOriginalName());
            $request->file('foto_1')->storeAs('public/', $path);
            $bankeu['foto_1'] = $path;
        }
        if ($request->file('foto_2') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('foto_2')->getClientOriginalName());
            $request->file('foto_2')->storeAs('public/', $path);
            $bankeu['foto_2'] = $path;
        }
        if ($request->file('video') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('video')->getClientOriginalName());
            $request->file('video')->storeAs('public/', $path);
            $bankeu['video'] = $path;
        }
        $id =  DB::table('bankeu')->insertGetId($bankeu);
        // dd(json_decode($request->geo_json));
        if ($request->geo_json) {
            $geo_json['geo_json'] = json_encode([
                "type" => "MultiLineString",
                "coordinates" => json_decode($request->geo_json),
                "crs" => ["type" => "name", "properties" => ["name" => "EPSG:4326"]]
            ]);
            $geo_json['id_bankeu'] = $id;
            // dd(json_encode($geo_json);

            $ruas_jalan_custom['flag_id'] = $id;
            $ruas_jalan_custom['flag'] = 'bankeu';
            $ruas_jalan_custom['keterangan'] = 'Custom ruas jalan dari bankeu';
            $ruas_jalan_custom['nama_lokasi'] = $request->nama_lokasi;
            $ruas_jalan_custom['geo_json'] = $geo_json['geo_json'];
            $id_ruas_jalan_custom = DB::table('ruas_jalan_custom')->insertGetId($ruas_jalan_custom);
            DB::table('bankeu')->where('id', $id)->update(['ruas_jalan_custom_id' => $id_ruas_jalan_custom]);
            DB::table('bankeu_geo_json')->insert($geo_json);
        }
        $historis["id_bankeu"] = $id;
        $historis['progress'] = $request->progress;
        $historis['progress_old'] = 0;
        $historis['updated_by'] = Auth::user()->id;
        $historis['updated_at'] = Carbon::now();
        DB::table('utils_historis_bankeu')->insert($historis);
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
        $kategori = DB::table('master_kategori_paket')->get();
        $penyedia_jasa = DB::connection('talikuat')->table('master_penyedia_jasa')->get();
        $konsultan = DB::connection('talikuat')->table('master_konsultan')->get();
        $bankeu = DB::table('bankeu')->where('id', $id)->first();
        $ppk = DB::connection('talikuat')->table('master_ppk')->get();
        $historis = DB::table('utils_historis_bankeu')->where('id_bankeu', $id)->get();
        // dd($historis);
        return view('admin.input_data.bankeu.progress', compact('bankeu', 'kategori', 'penyedia_jasa', 'konsultan', 'ppk', 'historis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ruas_jalan = DB::table('ruas_jalan_kabupaten_tarung')->select(['*'])->get();
        $kategori = DB::table('master_kategori_paket')->get();
        $penyedia_jasa = DB::connection('talikuat')->table('master_penyedia_jasa')->get();
        $konsultan = DB::connection('talikuat')->table('master_konsultan')->get();
        $bankeu = DB::table('bankeu')->where('id', $id)->first();
        $ppk = DB::connection('talikuat')->table('master_ppk')->get();
        $action = 'update';
        return view('admin.input_data.bankeu.insert', compact('action', 'bankeu', 'kategori', 'penyedia_jasa', 'konsultan', 'ppk', 'ruas_jalan'));
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
        $bankeu = $request->except(["_token", "_method", 'progress_old', 'foto', 'foto_1', 'foto_2', 'video']);
        $bankeu["updated_by"] = Auth::user()->id;
        $bankeu['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        if ($request->file('foto') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('foto')->getClientOriginalName());
            $request->file('foto')->storeAs('public/', $path);
            $bankeu['foto'] = $path;
        }
        if ($request->file('foto_1') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('foto_1')->getClientOriginalName());
            $request->file('foto_1')->storeAs('public/', $path);
            $bankeu['foto_1'] = $path;
        }
        if ($request->file('foto_2') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('foto_2')->getClientOriginalName());
            $request->file('foto_2')->storeAs('public/', $path);
            $bankeu['foto_2'] = $path;
        }
        if ($request->file('video') != null) {
            $path = 'bankeu/' . Str::snake(date("YmdHis") . ' ' . $request->file('video')->getClientOriginalName());
            $request->file('video')->storeAs('public/', $path);
            $bankeu['video'] = $path;
        }
        DB::table('bankeu')->where('id', $id)->update($bankeu);
        if ($request->progress !== $request->progress_old) {
            $historis["id_bankeu"] = $id;
            $historis['progress'] = $request->progress;
            $historis['progress_old'] = $request->progress_old;
            $historis['updated_by'] = Auth::user()->id;
            $historis['updated_at'] = Carbon::now();
            DB::table('utils_historis_bankeu')->insert($historis);
        }
        if ($request->geo_json) {
            $geo_json['geo_json'] = json_encode([
                "type" => "MultiLineString",
                "coordinates" => json_decode($request->geo_json),
                "crs" => ["type" => "name", "properties" => ["name" => "EPSG:4326"]]
            ]);
            $geo_json['id_bankeu'] = $id;

            $ruas_jalan_custom['keterangan'] = 'Custom ruas jalan dari bankeu';
            $ruas_jalan_custom['nama_lokasi'] = $request->nama_lokasi;
            $ruas_jalan_custom['geo_json'] = $geo_json['geo_json'];
            if (DB::table('bankeu')->where('id', $id)->count() > 1) {
                $id_ruas_jalan_custom = DB::table('ruas_jalan_custom')->insertGetId($ruas_jalan_custom);
                DB::table('bankeu')->where('id', $id)->update(['ruas_jalan_custom_id' => $id_ruas_jalan_custom]);
            } else
                DB::table('ruas_jalan_custom')->where('flag', 'bankeu')
                    ->where('flag_id', $id)->update($ruas_jalan_custom);

            DB::table('bankeu_geo_json')->where('id_bankeu', $id)->update($geo_json);
        }
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
        if (!(DB::table('bankeu')->where('id', $id)->count() > 1))
            DB::table('ruas_jalan_custom')->where('flag', 'bankeu')
                ->where('flag_id', $id)->delete();
        $temp = DB::table('bankeu')->where('id', $id)->delete();
        $color = "success";
        $msg = "Berhasil Menghapus Data Bantuan Keuangan";
        return redirect(route('bankeu.index'))->with(compact('color', 'msg'));
    }

    public function getRuasJalanByGeoId($id)
    {
        $ruas_jalan = DB::table('ruas_jalan_kabupaten_tarung')->where('geo_id', $id)->first();
        return response()->json(["coordinates" => json_decode($ruas_jalan->geo_json)->coordinates[0]], 200);
    }
}
