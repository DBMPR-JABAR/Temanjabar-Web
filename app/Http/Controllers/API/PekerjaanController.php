<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PekerjaanController extends Controller
{


    public function __construct()
    {
        $this->user = auth('api')->user();
        $this->userUptd = str_replace('uptd', '', $this->user->internalRole->uptd);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pekerjaan = DB::table('kemandoran')
                ->rightJoin('utils_pekerjaan', 'utils_pekerjaan.id_pek', '=', 'kemandoran.id_pek')
                ->where('is_deleted', 0)
                ->where('id_mandor', $this->user->id)
                ->get();

            $this->response['status'] = 'success';
            $this->response['data']['pekerjaan'] = $pekerjaan;

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'idSup' => 'required',
                'namaPaket' => 'required|string|min:5',
                'idRuasJalan' => 'required',
                'idJenisPekerjaan' => 'required',
                'lokasi' => 'required|string|min:3',
                'lat' => 'required|string',
                'long' => 'required|string',
                'panjang' => 'required|string',
                'jumlah_pekerja' => 'required|string',
                'peralatan' => 'required|string',
                'fotoAwal' => 'file',
                'fotoSedang' => 'file',
                'fotoAkhir' => 'file',
                'video' => 'mimes:mp4'
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }

            $pekerjaan = [];
            $pekerjaan['nama_mandor'] = $this->user->name;
            $pekerjaan['user_id'] = $this->user->id;
            $pekerjaan['created_by'] = $this->user->id;
            $pekerjaan['tanggal'] = $request->tanggal;
            $pekerjaan['sup_id'] = $request->idSup;
            $pekerjaan['sup'] = DB::table('utils_sup')->where('id', $request->idSup)->first()->name;
            $pekerjaan['paket'] = $request->namaPaket;
            $pekerjaan['ruas_jalan_id'] = $request->idRuasJalan;
            $pekerjaan['ruas_jalan'] = DB::table('master_ruas_jalan')
                ->where('id_ruas_jalan', $request->idRuasJalan)->first()->nama_ruas_jalan;
            $pekerjaan['jenis_pekerjaan'] = DB::table('item_pekerjaan')->where('no', $request->idJenisPekerjaan)->first()->nama_item;
            $pekerjaan['peralatan'] = $request->peralatan;
            $pekerjaan['panjang'] = $request->panjang;
            $pekerjaan['jumlah_pekerja'] = $request->jumlah_pekerja;

            $pekerjaan['lat'] = $request->lat;
            $pekerjaan['lng'] = $request->long;

            if ($request->fotoAwal != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->fotoAwal->getClientOriginalName());
                $request->fotoAwal->storeAs('public/pekerjaan/', $path);
                $pekerjaan['foto_awal'] = $path;
            }
            if ($request->fotoSedang != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->fotoSedang->getClientOriginalName());
                $request->fotoSedang->storeAs('public/pekerjaan/', $path);
                $pekerjaan['foto_sedang'] = $path;
            }
            if ($request->fotoAkhir != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->fotoAkhir->getClientOriginalName());
                $request->fotoAkhir->storeAs('public/pekerjaan/', $path);
                $pekerjaan['foto_akhir'] = $path;
            }
            if ($request->video != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->video->getClientOriginalName());
                $request->video->storeAs('public/pekerjaan/', $path);
                $pekerjaan['video'] = $path;
            }

            $row = DB::table('kemandoran')->select('id_pek')->orderByDesc('id_pek')->limit(1)->first();

            $pekerjaan['uptd_id'] = $this->userUptd == '' ? 0 : $this->userUptd;
            $pekerjaan['tglreal'] = date('Y-m-d H:i:s');
            $pekerjaan['is_deleted'] = 0;
            $nomor = intval(substr($row->id_pek, strlen('CK-'))) + 1;
            $pekerjaan['id_pek'] = 'CK-' . str_pad($nomor, 6, "0", STR_PAD_LEFT);

            DB::table('kemandoran')->insert($pekerjaan);
            DB::table('utils_pekerjaan')->insert([
                'id_mandor' => $this->user->id,
                'id_pek' => $pekerjaan['id_pek']
            ]);
            $this->response['status'] = 'success';
            $this->response['data']['message'] = 'Berhasil menambahkan pekerjaan';
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error' . $th;
            return response()->json($this->response, 500);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'date',
                'idSup' => 'int',
                'namaPaket' => 'string|min:5',
                'idRuasJalan' => 'string',
                'idJenisPekerjaan' => 'int',
                'lokasi' => 'string|min:3',
                'lat' => 'string',
                'long' => 'string',
                'panjang' => 'string',
                'jumlah_pekerja' => 'string',
                'peralatan' => 'string',
                'fotoAwal' => 'file',
                'fotoSedang' => 'file',
                'fotoAkhir' => 'file',
                'video' => 'mimes:mp4'
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }

            $pekerjaan = [];
            $pekerjaan['tanggal'] = $request->tanggal;
            $pekerjaan['sup'] = DB::table('utils_sup')->where('id', $request->idSup)->first()->name;
            $pekerjaan['paket'] = $request->namaPaket;
            $pekerjaan['ruas_jalan'] = DB::table('master_ruas_jalan')
                ->where('id_ruas_jalan', $request->idRuasJalan)->first()->nama_ruas_jalan;
            $pekerjaan['jenis_pekerjaan'] = DB::table('item_pekerjaan')->where('no', $request->idJenisPekerjaan)->first()->nama_item;
            $pekerjaan['peralatan'] = $request->peralatan;
            $pekerjaan['panjang'] = $request->panjang;
            $pekerjaan['lat'] = $request->lat;
            $pekerjaan['lng'] = $request->long;

            if ($request->fotoAwal != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->fotoAwal->getClientOriginalName());
                $request->fotoAwal->storeAs('public/pekerjaan/', $path);
                $pekerjaan['foto_awal'] = $path;
            }
            if ($request->fotoSedang != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->fotoSedang->getClientOriginalName());
                $request->fotoSedang->storeAs('public/pekerjaan/', $path);
                $pekerjaan['foto_sedang'] = $path;
            }
            if ($request->fotoAkhir != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->fotoAkhir->getClientOriginalName());
                $request->fotoAkhir->storeAs('public/pekerjaan/', $path);
                $pekerjaan['foto_akhir'] = $path;
            }
            if ($request->video != null) {
                $path = Str::snake(date("YmdHis") . ' ' . $request->video->getClientOriginalName());
                $request->video->storeAs('public/pekerjaan/', $path);
                $pekerjaan['video'] = $path;
            }

            $pekerjaan['uptd_id'] = $this->userUptd == '' ? 0 : $this->userUptd;

            DB::table('kemandoran')->where('id_pek', $id)->update($pekerjaan);
            $this->response['status'] = 'success';
            $this->response['data']['message'] = 'Berhasil merubah pekerjaan';
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error' . $th;
            return response()->json($this->response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::table('kemandoran')->where('id_pek', $id)->update(['is_deleted' => 1]);

            $this->response['status'] = 'success';
            $this->response['data']['message'] = 'Berhasil menghapus Pekerjaan';
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getSUP()
    {
        try {
            $sup = DB::table('utils_sup')
                ->where('uptd_id', $this->userUptd)
                ->get();

            $this->response['status'] = 'success';
            $this->response['data']['sup'] = $sup;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getRuasJalan()
    {
        try {
            $ruasJalan = DB::table('master_ruas_jalan')
                ->where('uptd_id', $this->userUptd)
                ->get();

            $this->response['status'] = 'success';
            $this->response['data']['ruas_jalan'] = $ruasJalan;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getJenisPekerjaan()
    {
        try {
            $jenisPekerjaan = DB::table('item_pekerjaan')
                ->get();

            $this->response['status'] = 'success';
            $this->response['data']['jenis_pekerjaan'] = $jenisPekerjaan;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
}
