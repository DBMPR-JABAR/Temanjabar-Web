<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MaterialPekerjaanController extends Controller
{
    public function __construct()
    {
        $this->user = auth('api')->user();
        if (!$this->user) {
            $this->response['message'] = 'Unauthorized';
            return response()->json($this->response, 200);
        }
        // $this->userUptd = str_replace('uptd', '', $this->user->internalRole->uptd);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                'id_pek' => 'required',
                'jenis_pekerjaan' => 'required|string',
                'nama_bahan1' => 'required|string',
                'jum_bahan1' => 'required|string',
                'satuan1' => 'required|string',
                
                'uptd_id' => 'required|int'
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }

            $sudahAda = DB::table('bahan_material')->where('id_pek', $request->id_pek)->count();

            if ($sudahAda) {
                $this->response['status'] = 'success';
                $this->response['data']['message'] = 'Bahan material sudah ada, silahkan update';
                return response()->json($this->response, 200);
            }

            $request['tanggal'] = Carbon::now();
            $request['nama_mandor'] = $this->user->name;
            $bahan_tiba =$request->except([
                'nama_peralatan',
                'jum_peralatan',
                'satuan_peralatan',
                'nama_bahan_operasional',
                'jum_bahan_operasional',
                'satuan_operasional',
                'jabatan_pekerja',
                'jum_pekerja',
                'jenis_gangguan',
                'start_time',
                'end_time',
                'akibat',
                'tanggal',
            ]); 
            DB::table('bahan_material')->insert($bahan_tiba);
                 
            $kemandoran = DB::table('kemandoran')->where('id_pek', $request->id_pek);
            $kemandoranUpdate['mail'] = 1;
            $kemandoran->update($kemandoranUpdate);
            $this->response['status'] = 'success';
            $this->response['data']['message'] = 'Berhasil Menambah Material Pekerjaan';

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error ';
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
        try {
            $bahan_material = DB::table('bahan_material')->where('id_pek', $id)->first();
            $this->response['status'] = 'success';
            $this->response['data']['bahan_material'] = $bahan_material;
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error ';
            return response()->json($this->response, 500);
        }
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
                'jenis_pekerjaan' => 'string',
                'peralatan' => 'required|string',
                'nama_bahan1' => 'string',
                'jum_bahan1' => 'string',
                'satuan1' => 'string',
                'nama_bahan2' => 'string',
                'jum_bahan2' => 'string',
                'satuan2' => 'string',
                'nama_bahan3' => 'string',
                'jum_bahan3' => 'string',
                'satuan3' => 'string',
                'nama_bahan4' => 'string',
                'jum_bahan4' => 'string',
                'satuan4' => 'string',
                'nama_bahan5' => 'string',
                'jum_bahan5' => 'string',
                'satuan5' => 'string',
                'nama_bahan6' => 'string',
                'jum_bahan6' => 'string',
                'satuan6' => 'string',
                'nama_bahan7' => 'string',
                'jum_bahan7' => 'string',
                'satuan7' => 'string',
                'nama_bahan8' => 'string',
                'jum_bahan8' => 'string',
                'satuan8' => 'string',
                'nama_bahan9' => 'string',
                'jum_bahan9' => 'string',
                'satuan9' => 'string',
                'nama_bahan10' => 'string',
                'jum_bahan10' => 'string',
                'satuan10' => 'string',
                'nama_bahan11' => 'string',
                'jum_bahan11' => 'string',
                'satuan11' => 'string',
                'nama_bahan12' => 'string',
                'jum_bahan12' => 'string',
                'satuan12' => 'string',
                'nama_bahan13' => 'string',
                'jum_bahan13' => 'string',
                'satuan13' => 'string',
                'nama_bahan14' => 'string',
                'jum_bahan14' => 'string',
                'satuan14' => 'string',
                'nama_bahan15' => 'string',
                'jum_bahan15' => 'string',
                'satuan15' => 'string',
                'uptd_id' => 'required|int'
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }

            $request['nama_mandor'] = $this->user->name;
            DB::table('bahan_material')->where('id_pek', $id)->update($request->except('_method','peralatan'));

            $kemandoran = DB::table('kemandoran')->where('id_pek', $id);
            $kemandoranUpdate['mail'] = 1;
            $kemandoranUpdate['peralatan'] = $request->peralatan;
            $kemandoran->update($kemandoranUpdate);

            $this->response['status'] = 'success';
            $this->response['data']['message'] = 'Berhasil Memperbaharui Material Pekerjaan';

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error ' . $e;
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
        //
    }

    public function bahanMaterial()
    {
        try {
            $bahan_material = DB::table('item_bahan')->select('no', 'nama_item')->where('keterangan',null)->get();
            $this->response['status'] = 'success';
            $this->response['data']['bahan_material'] = $bahan_material;
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error ';
            return response()->json($this->response, 500);
        }
    }
    public function getAlatOperasional()
    {
        try {
            $alatOperasional = DB::table('item_peralatan')
                ->get();

            $this->response['status'] = 'success';
            $this->response['data']['alat_operasional'] = $alatOperasional;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function getBahanMaterialOperasional()
    {
        try {
            $jenisPekerjaan = DB::table('item_bahan')->where('keterangan','Bahan Operasional')
                ->get();

            $this->response['status'] = 'success';
            $this->response['data']['jenis_pekerjaan'] = $jenisPekerjaan;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function satuanMaterial()
    {
        try {
            $satuan_material = DB::table('item_satuan')->get();
            $this->response['status'] = 'success';
            $this->response['data']['satuan_material'] = $satuan_material;
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error ';
            return response()->json($this->response, 500);
        }
    }
}
