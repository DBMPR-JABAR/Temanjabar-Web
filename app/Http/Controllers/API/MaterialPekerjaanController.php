<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Model\Transactional\PekerjaanPemeliharaan as Pemeliharaan;
// use App\Model\Transactional\PemeliharaanDetailPeralatan as DetailPeralatan;
use App\Model\Transactional\PemeliharaanDetailMaterial as DetailMaterial;

use App\ItemPeralatan;

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
                'jenis_pekerjaan' => '',
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
            $pekerjaan['id_pek']=$id;
            $pekerjaan['uptd_id'] = $temp->uptd_id;
            $pekerjaan['updated_by'] =$this->user->id;
            $pekerjaan['nama_mandor']=$temp->nama_mandor;
            $pekerjaan['jenis_pekerjaan']=$temp->jenis_pekerjaan;
            $pekerjaan['tanggal']=$temp->tanggal;
            $temp_save_peralatan_id=[];
            $temp_save_peralatan_jum=[];
            $temp_save_peralatan_satuan=[];
            
            for($i = 0; $i<count($request->peralatan_id) ;$i++){
                if (in_array($request->peralatan_id[$i], $temp_save_peralatan_id)) {
                    $k = array_search($request->peralatan_id[$i], $temp_save_peralatan_id);
                    $temp_save_peralatan_jum[$k]+=$request->jum_peralatan[$i];
                } else {
                    $temp_save_peralatan_id[]=$request->peralatan_id[$i];
                    $temp_save_peralatan_jum[]=$request->jum_peralatan[$i];
                    $temp_save_peralatan_satuan[]=$request->satuan_peralatan[$i];

                }
            }
           
            for($i = 0; $i<count($temp_save_peralatan_jum) ;$i++){
                if($temp_save_peralatan_jum[$i] > 0 && $temp_save_peralatan_jum[$i] != null){
                    $peralatan['id_pek'] = $id;
                    // $temp_peralatan=explode(",",$request->nama_peralatan[$i]);
                    $temp_peralatan = ItemPeralatan::find($temp_save_peralatan_id[$i]);
                    $peralatan['id_peralatan'] = $temp_peralatan->id;
                    $peralatan['nama_peralatan'] = $temp_peralatan->nama_peralatan;
                    $peralatan['kuantitas'] = $temp_save_peralatan_jum[$i];
                    $peralatan['satuan'] = $temp_save_peralatan_satuan[$i];
                    // $temp->detailPeralatan()->create($peralatan);
                    DB::table('kemandoran_detail_peralatan')->insert($peralatan);
                }
            }

            $temp_save_bahan_operasional_id=[];
            $temp_save_bahan_operasional_jum=[];
            $temp_save_bahan_operasional_satuan=[];
            for($i = 0; $i<count($request->bahan_operasional_id) ;$i++){
                if (in_array($request->bahan_operasional_id[$i], $temp_save_bahan_operasional_id)) {
                    $k = array_search($request->bahan_operasional_id[$i], $temp_save_bahan_operasional_id);
                    $temp_save_bahan_operasional_jum[$k]+=$request->jum_bahan_operasional[$i];
                } else {
                    $temp_save_bahan_operasional_id[]=$request->bahan_operasional_id[$i];
                    $temp_save_bahan_operasional_jum[]=$request->jum_bahan_operasional[$i];
                    $temp_save_bahan_operasional_satuan[]=$request->satuan_bahan_operasional[$i];

                }
            }
            
            for($i = 0; $i<count($temp_save_bahan_operasional_jum) ;$i++){
                if($temp_save_bahan_operasional_jum[$i] > 0 && $temp_save_bahan_operasional_jum[$i] != null){
                    $material['id_pek'] = $id;
                    $material['id_material'] = $temp_save_bahan_operasional_id[$i];
                    $material['kuantitas'] = $temp_save_bahan_operasional_jum[$i];
                    $material['satuan'] = $temp_save_bahan_operasional_satuan[$i];
                    DB::table('kemandoran_detail_material')->insert($material);
                }
            }
            
            $temp_save_jabatan_pekerja=[];
            $temp_save_pekerja_jum=[];
            for($i = 0; $i<count($request->jabatan_pekerja) ;$i++){
                if (in_array($request->jabatan_pekerja[$i], $temp_save_jabatan_pekerja)) {
                    $k = array_search($request->jabatan_pekerja[$i], $temp_save_jabatan_pekerja);
                    $temp_save_pekerja_jum[$k]+=$request->jum_pekerja[$i];
                } else {
                    $temp_save_jabatan_pekerja[]=$request->jabatan_pekerja[$i];
                    $temp_save_pekerja_jum[]=$request->jum_pekerja[$i];
                }
            }
            for($i = 0; $i<count($temp_save_pekerja_jum) ;$i++){
                if($temp_save_bahan_operasional_jum[$i] > 0 && $temp_save_bahan_operasional_jum[$i] != null){
                    $pekerja['id_pek'] = $id;
                    $pekerja['jabatan'] = $temp_save_jabatan_pekerja[$i];
                    $pekerja['jumlah'] = $temp_save_pekerja_jum[$i] ? :0;
                    DB::table('kemandoran_detail_pekerja')->insert($pekerja);
                }
            }
            
            for($i = 0; $i<count($request->jenis_gangguan) ;$i++){
                if($request->start_time[$i] != null){
                    $penghambat['id_pek'] = $id;
                    $penghambat['jenis_gangguan'] = $request->jenis_gangguan[$i];
                    $penghambat['start_time'] = $request->start_time[$i];
                    $penghambat['end_time'] = $request->end_time[$i];
                    $penghambat['akibat'] = $request->akibat[$i];
                    DB::table('kemandoran_detail_penghambat')->insert($penghambat);
                }
            }
           
            
            $temp_save_nama_bahan=[];
            $temp_save_bahan_jum=[];
            $temp_save_bahan_satuan=[];
            for($i = 0; $i<count($request->nama_bahan) ;$i++){
                if (in_array($request->nama_bahan[$i], $temp_save_nama_bahan)) {
                    $k = array_search($request->nama_bahan[$i], $temp_save_nama_bahan);
                    $temp_save_bahan_jum[$k]+=$request->jum_bahan[$i];
                } else {
                    $temp_save_nama_bahan[]=$request->nama_bahan[$i];
                    $temp_save_bahan_jum[]=$request->jum_bahan[$i];
                    $temp_save_bahan_satuan[]=$request->satuan_bahan[$i];
                }
            }
            
            $x=1;
            for($i = 0; $i<count($temp_save_nama_bahan) ;$i++){
                if($temp_save_bahan_jum[$i] > 0 && $temp_save_bahan_jum[$i] != null){
                    $jum_bahan = "jum_bahan$x";
                    $nama_bahan = "nama_bahan$x";
                    $satuan = "satuan$x";
                    $pekerjaan[$nama_bahan]=$temp_save_nama_bahan[$i];
                    $pekerjaan[$jum_bahan]=$temp_save_bahan_jum[$i];
                    $pekerjaan[$satuan]=$temp_save_bahan_satuan[$i];
                    $x++;
                }
            }
          
            if(str_contains(Auth::user()->internalRole->role,'Pengamat')){
                if($request->keterangan_instruksi){
                    $keterangan_instruksi['id_pek'] = $id;
                    $keterangan_instruksi['user_id'] =$this->user->id;
                    $keterangan_instruksi['keterangan'] = $request->keterangan_instruksi;
                    DB::table('kemandoran_detail_instruksi')->insert($keterangan_instruksi);
                }
            }
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Berhasil Material',
            //     'data' => $pekerjaan
            // ]);
            DetailMaterial::create($pekerjaan);
            $kemandoran =  DB::table('kemandoran');
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Berhasil Menambahkan',
            //     'id' => $request->nama_bahan,
            //     'kuantitas' => $request->jum_bahan,
            //     'satuan' => $request->satuan_bahan,
            //     'id1' => $temp_save_nama_bahan,
            //     'kuantitas1' => $temp_save_bahan_jum,
            // ]);
            if($kemandoran->where('id_pek', $id)->where('mail', null)->exists()){
                $mail['mail'] = 1;
                
                $kemandoran->update($mail);
                $detail_adjustment =  DB::table('kemandoran_detail_status');
                $data['pointer'] = 0;
                $data['adjustment_user_id'] =$this->user->id;
                $data['status'] = "Submitted";
                $data['id_pek'] = $id;
                $data['updated_at'] = Carbon::now();
                $data['created_at'] = Carbon::now();
                $data['created_by'] =$this->user->id;
                if(str_contains(Auth::user()->internalRole->role,'Admin')){
                    $data['adjustment_user_id'] = $temp->user_id;
                }
                $insert = $detail_adjustment->insert($data);
            }
            storeLogActivity(declarLog(1, 'Detail Pemeliharaan Pekerjaan', $id, 1 ));
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Material'
            ]);
        } catch (\Exception $e) {
           
            $this->response['data']['tess'] = json_decode($request->peralatan_operasional);
            
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    // Peralatan
    public function storePeralatan(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'peralatan' => ''
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            
            $cek = DB::table('kemandoran_detail_peralatan')->where('id_pek',$id);
            if($cek->exists()){
                storeLogActivity(declarLog(2, 'Detail Pemeliharaan - Peralatan', $id, 1 ));

                $cek->delete();
            }
            $request = $request->json()->all();

            $temp_save_peralatan_id=[];
            $temp_save_peralatan_jum=[];
            $temp_save_peralatan_satuan=[];
            
            for($i = 0; $i<count($request['peralatan']) ;$i++){
                if (in_array($request['peralatan'][$i]['peralatan_id'], $temp_save_peralatan_id)) {
                    $k = array_search($request['peralatan'][$i]['peralatan_id'], $temp_save_peralatan_id);
                    $temp_save_peralatan_jum[$k]+=$request['peralatan'][$i]['jum_peralatan'];
                } else {
                    $temp_save_peralatan_id[]=$request['peralatan'][$i]['peralatan_id'];
                    $temp_save_peralatan_jum[]=$request['peralatan'][$i]['jum_peralatan'];
                    $temp_save_peralatan_satuan[]=$request['peralatan'][$i]['satuan_peralatan'];

                }
            }
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Berhasil Material',
            //     'data' => $temp_save_peralatan_jum
            // ]);
            for($i = 0; $i<count($temp_save_peralatan_jum) ;$i++){
                if($temp_save_peralatan_jum[$i] > 0 && $temp_save_peralatan_jum[$i] != null){
                    $peralatan['id_pek'] = $id;
                    // $temp_peralatan=explode(",",$request->nama_peralatan[$i]);
                    $temp_peralatan = ItemPeralatan::find($temp_save_peralatan_id[$i]);
                    $peralatan['id_peralatan'] = $temp_peralatan->id;
                    $peralatan['nama_peralatan'] = $temp_peralatan->nama_peralatan;
                    $peralatan['kuantitas'] = $temp_save_peralatan_jum[$i];
                    $peralatan['satuan'] = $temp_save_peralatan_satuan[$i];
                    // $temp->detailPeralatan()->create($peralatan);
                    DB::table('kemandoran_detail_peralatan')->insert($peralatan);
                }
            }

            
            storeLogActivity(declarLog(1, 'Detail Pemeliharaan - Peralatan', $id, 1 ));
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Melengkapi Data Peralatan!'
            ]);
        } catch (\Exception $e) {
           
            // $this->response['data']['tess'] = json_decode($request->peralatan_operasional);
            
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function getPeralatan($id)
    {
        //
        try {
            $data = DB::table('kemandoran_detail_peralatan')->where('id_pek',$id)->get();
            if(count($data)>0){
                $this->response['success'] = true;
                $this->response['message'] = 'Data Peralatan';
                $this->response['data'] = $data;
                
            }else{
                $this->response['success'] = false;
                $this->response['message'] = 'Data Peralatan Kosong';
            }
            return response()->json($this->response, 200);

            
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }

    }
    // Bahan Operasional 
    public function storeBahanOperasional(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'bahan_operasional' => ''
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            
            $cek = DB::table('kemandoran_detail_material')->where('id_pek',$id);
            if($cek->exists()){
                storeLogActivity(declarLog(2, 'Detail Pemeliharaan - Bahan Operasional', $id, 1 ));
                $cek->delete();
            }
            $request = $request->json()->all();

            $temp_save_bahan_operasional_id=[];
            $temp_save_bahan_operasional_jum=[];
            $temp_save_bahan_operasional_satuan=[];
            
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Berhasil Material',
            //     'data' => $request['bahan_operasional']
            // ]);

            for($i = 0; $i<count($request['bahan_operasional']) ;$i++){
                if (in_array($request['bahan_operasional'][$i]['bahan_operasional_id'], $temp_save_bahan_operasional_id)) {
                    $k = array_search($request['bahan_operasional'][$i]['bahan_operasional_id'], $temp_save_bahan_operasional_id);
                    $temp_save_bahan_operasional_jum[$k]+=$request['bahan_operasional'][$i]['jum_bahan_operasional'];
                } else {
                    $temp_save_bahan_operasional_id[]=$request['bahan_operasional'][$i]['bahan_operasional_id'];
                    $temp_save_bahan_operasional_jum[]=$request['bahan_operasional'][$i]['jum_bahan_operasional'];
                    $temp_save_bahan_operasional_satuan[]=$request['bahan_operasional'][$i]['satuan_bahan_operasional'];

                }
            }

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Berhasil Material',
            //     'data' => $temp_save_bahan_operasional_jum
            // ]);
        
            for($i = 0; $i<count($temp_save_bahan_operasional_jum) ;$i++){
                if($temp_save_bahan_operasional_jum[$i] > 0 && $temp_save_bahan_operasional_jum[$i] != null){
                    $material['id_pek'] = $id;
                    $material['id_material'] = $temp_save_bahan_operasional_id[$i];
                    $material['kuantitas'] = $temp_save_bahan_operasional_jum[$i];
                    $material['satuan'] = $temp_save_bahan_operasional_satuan[$i];
                    DB::table('kemandoran_detail_material')->insert($material);
                }
            }

            storeLogActivity(declarLog(1, 'Detail Pemeliharaan - Bahan Operasional', $id, 1 ));
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Melengkapi Data Bahan Operasional!'
            ]);
        } catch (\Exception $e) {
           
            // $this->response['data']['tess'] = json_decode($request->peralatan_operasional);
            
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function getBahanOperasional($id)
    {
        //
        try {
            $data = DB::table('kemandoran_detail_material')->where('id_pek',$id)->get();
            if(count($data)>0){
                $this->response['success'] = true;
                $this->response['message'] = 'Data Bahan Operasional';
                $this->response['data'] = $data;
                
            }else{
                $this->response['success'] = false;
                $this->response['message'] = 'Data Bahan Operasional Kosong';
            }
            return response()->json($this->response, 200);

            
        } catch (\Exception $e) {
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
            $this->response['data'] = $bahan_material;
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
            $this->response['data'] = $alatOperasional;

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
            $this->response['data'] = $jenisPekerjaan;

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
            $this->response['data'] = $satuan_material;
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error ';
            return response()->json($this->response, 500);
        }
    }
}
