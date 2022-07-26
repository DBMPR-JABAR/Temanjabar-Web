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
    public function store(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'jenis_pekerjaan' => 'required|string',
                // 'nama_bahan1' => 'required|string',
                // 'jum_bahan1' => 'required|string',
                // 'satuan1' => 'required|string',
                
                'bahan_material' => '',
                'peralatan_operasional' => '',
                'bahan_operasional' => '',
                'pekerja' => '',
                'penghambat_pelaksanaan' =>'',
                'uptd_id' => ''
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }

            $temp = Pemeliharaan::where('id_pek', $id)->first();
            // dd($pekerjaan['keterangan_instruksi']);
            $pekerjaan['uptd_id'] = $temp->uptd_id;
            $pekerjaan['updated_by'] = Auth::user()->id;
            $pekerjaan['nama_mandor']=$temp->nama_mandor;
            $pekerjaan['jenis_pekerjaan']=$temp->jenis_pekerjaan;
            $pekerjaan['tanggal']=$temp->tanggal;
            // dd($pekerjaan);
            $x=1;
            for($i = 0; $i<count($request->nama_bahan)-1 ;$i++){
                $jum_bahan = "jum_bahan$x";
                $nama_bahan = "nama_bahan$x";
                $satuan = "satuan$x";
                $pekerjaan[$nama_bahan]=$request->nama_bahan[$i];
                $pekerjaan[$jum_bahan]=$request->jum_bahan[$i];
                $pekerjaan[$satuan]=$request->satuan[$i];
                $x++;
            }
            for($i = 0; $i<count($request->jum_peralatan)-1 ;$i++){
                if($request->jum_peralatan[$i] != null){
                    $peralatan['id_pek'] = $id;
                    $temp_peralatan=explode(",",$request->nama_peralatan[$i]);
                    $peralatan['id_peralatan'] = $temp_peralatan[0];
                    $peralatan['nama_peralatan'] = $temp_peralatan[1];
                    $peralatan['kuantitas'] = $request->jum_peralatan[$i];
                    $peralatan['satuan'] = $request->satuan_peralatan[$i];
                    DB::table('kemandoran_detail_peralatan')->insert($peralatan);
                }
            }
            for($i = 0; $i<count($request->jum_bahan_operasional)-1 ;$i++){
                if($request->jum_bahan_operasional[$i] != null){
                    $material['id_pek'] = $id;
                    $material['id_material'] = $request->nama_bahan_operasional[$i];
                    $material['kuantitas'] = $request->jum_bahan_operasional[$i];
                    $material['satuan'] = $request->satuan_operasional[$i];
                    DB::table('kemandoran_detail_material')->insert($material);
                }
            }
            for($i = 0; $i<count($request->jabatan_pekerja)-1 ;$i++){
                $pekerja['id_pek'] = $id;
                $pekerja['jabatan'] = $request->jabatan_pekerja[$i];
                $pekerja['jumlah'] = $request->jum_pekerja[$i] ? :0;
                DB::table('kemandoran_detail_pekerja')->insert($pekerja);
            }
            for($i = 0; $i<count($request->jenis_gangguan)-1 ;$i++){
                if($request->start_time[$i] != null){
                    $penghambat['id_pek'] = $id;
                    $penghambat['jenis_gangguan'] = $request->jenis_gangguan[$i];
                    $penghambat['start_time'] = $request->start_time[$i];
                    $penghambat['end_time'] = $request->end_time[$i];
                    $penghambat['akibat'] = $request->akibat[$i];
                    DB::table('kemandoran_detail_penghambat')->insert($penghambat);
                }
            }
            // dd($pekerjaan);
            if(str_contains(Auth::user()->internalRole->role,'Pengamat')){
                $keterangan_instruksi['id_pek'] = $id;
                $keterangan_instruksi['user_id'] = Auth::user()->id;
                $keterangan_instruksi['keterangan'] = $request->keterangan_instruksi;
                DB::table('kemandoran_detail_instruksi')->insert($keterangan_instruksi);
            }
            DB::table('bahan_material')->insert($pekerjaan);
            $kemandoran =  DB::table('kemandoran');

            if($kemandoran->where('id_pek', $id)->where('mail', null)->exists()){
                $mail['mail'] = 1;
                
                $kemandoran->update($mail);
                $detail_adjustment =  DB::table('kemandoran_detail_status');
                $data['pointer'] = 0;
                $data['adjustment_user_id'] = Auth::user()->id;
                $data['status'] = "Submitted";
                $data['id_pek'] = $id;
                $data['updated_at'] = Carbon::now();
                $data['created_at'] = Carbon::now();
                $data['created_by'] = Auth::user()->id;
                if(str_contains(Auth::user()->internalRole->role,'Admin')){
                    $data['adjustment_user_id'] = $temp->user_id;
                }
                $insert = $detail_adjustment->insert($data);
            }
            storeLogActivity(declarLog(1, 'Detail Pemeliharaan Pekerjaan', $id, 1 ));

        } catch (\Exception $e) {
           
            $this->response['data']['tess'] = json_decode($request->peralatan_operasional);
            
            $this->response['data']['message'] = 'Internal Error';
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
            $bahan_material = DB::table('item_bahan')->select('no', 'nama_item')->where('keterangan','!=','Bahan Operasional')->orWhere('keterangan',null)->get();
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
