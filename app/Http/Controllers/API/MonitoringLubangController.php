<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Model\Transactional\MonitoringLubangSurvei as SurveiLubang;
use App\Model\Transactional\MonitoringLubangSurveiDetail as SurveiLubangDetail;
use App\Model\Transactional\MonitoringPotensiLubangSurvei as SurveiPotensiLubang;
use App\Model\Transactional\MonitoringPotensiLubangSurveiDetail as SurveiPotensiLubangDetail;
use App\Model\Transactional\MonitoringLubangPenanganan as PenangananLubang;
use App\Model\Transactional\MonitoringLubangPenangananDetail as PenangananLubangDetail;

use App\Model\Transactional\MonitoringLubangRencanaPenanganan as RencanaPenanganan;


use App\Model\Transactional\RuasJalan;

class MonitoringLubangController extends Controller
{
    //
    public function indexSurvei()
    {
        try {
            $filter['tanggal_awal'] = Carbon::now()->subDays(14)->format('Y-m-d');
            $filter['tanggal_akhir'] = Carbon::now()->format('Y-m-d');
            $data = SurveiLubang::whereBetween('tanggal', [$filter['tanggal_awal'], $filter['tanggal_akhir']])->latest('tanggal');
            if (Auth::user() && Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $data = $data->where('uptd_id', $uptd_id);
                if (str_contains(Auth::user()->internalRole->role, 'Mandor')) {
                    $data = $data->where('created_by', Auth::user()->id);
                } else if (Auth::user()->sup_id) {
                    $data = $data->where('sup_id', Auth::user()->sup_id);
                    if (count(Auth::user()->ruas) > 0) {
                        $data = $data->whereIn('ruas_jalan_id', Auth::user()->ruas->pluck('id_ruas_jalan')->toArray());
                    }
                }
            }
            $data = $data->get();
            return response()->json([
                'success' => true,
                'message' => 'Data Penanganan',
                'data'  => $data
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function getRekap()
    {
        try {
            
            $data = SurveiLubangDetail::latest('tanggal');
            $data1 = SurveiLubangDetail::latest('tanggal');
            $data2 = SurveiLubangDetail::latest('tanggal');
            if (Auth::user() && Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $data = $data->where('uptd_id', $uptd_id);
                $data1 = $data->where('uptd_id', $uptd_id);
                $data2 = $data->where('uptd_id', $uptd_id);
                if (str_contains(Auth::user()->internalRole->role, 'Mandor')) {
                    $data = $data->where('created_by', Auth::user()->id);
                    $data1 = $data->where('created_by', Auth::user()->id);
                    $data2 = $data->where('created_by', Auth::user()->id);
                } else if (Auth::user()->sup_id) {
                    $data = $data->where('sup_id', Auth::user()->sup_id);
                    $data1 = $data->where('sup_id', Auth::user()->sup_id);
                    $data2 = $data->where('sup_id', Auth::user()->sup_id);
                    if (count(Auth::user()->ruas) > 0) {
                        $data = $data->whereIn('ruas_jalan_id', Auth::user());
                        $data1 = $data->whereIn('ruas_jalan_id', Auth::user());
                        $data2 = $data->whereIn('ruas_jalan_id', Auth::user());
                    }
                }
            }
            $temporari['data_survei'] = $data->whereNull('status')->get()->count();
            $temporari['perencanaan'] = $data1->where('status','Perencanaan')->get()->count();
            $temporari['penanganan'] = $data2->where('status','Selesai')->get()->count();
           
            return response()->json([
                'success' => true,
                'message' => 'Data Penanganan',
                'data'  => $temporari
            ]);

        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function startSurvei(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(1, 'Survei Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            if(!isset($ruas)){   
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
            $survei = SurveiLubang::where([
                ['tanggal', $request->tanggal],
                ['created_by' ,Auth::user()->id],
                ['ruas_jalan_id',$request->ruas_jalan_id],
                ['sup_id',$ruas->data_sup->id]
            ])->first();
            if(isset($survei)){
                $survei->jumlah = $survei->SurveiLubangDetail->sum('jumlah');
                $survei->panjang = $survei->SurveiLubangDetail->sum('panjang');
                $survei->ruas = $survei->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
            }else{
                $survei =([
                    'jumlah'=>0,
                    'panjang'=>0,
                    'tanggal'=>$request->tanggal,
                    'ruas_jalan_id'=>$request->ruas_jalan_id,
                    'ruas'=>$ruas->select('id_ruas_jalan','nama_ruas_jalan')->where('id_ruas_jalan',$request->ruas_jalan_id)->get(),
                    'survei_lubang_detail'=>[]
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => $survei,  
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function storeSurvei(Request $request, $desc)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'jumlah' => '',
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
                'lokasi_kode' => 'required',
                'lokasi_km' => '',
                'lokasi_m' => '',
                'lat' => 'required',
                'long' => 'required',
                'image' => '',
                'kategori' => '',
                'panjang' => '',
                'description' =>'',
                'lajur' =>'',
                'potensi_lubang'=>''
            ]);
            
            if($request->kategori == "Group"){
                $validator = Validator::make($request->all(), [
                    'jumlah' => 'required|numeric',
                ]);
            }
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(1, 'Survei Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            
            if(!isset($ruas)){   
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }

            $find = [
                'tanggal'=> $request->tanggal,
                'created_by' =>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id,
                'sup_id'=>$ruas->data_sup->id,
                'kota_id'=>$ruas->kota_id,
                'lokasi_kode' => Str::upper($request->lokasi_kode),
            ];
            $temporari =[
                'lat' => $request->lat,
                'long' => $request->long,
                'lokasi_kode' => Str::upper($request->lokasi_kode),
                'lokasi_km' => $request->lokasi_km,
                'lokasi_m' => $request->lokasi_m,
                'created_by' =>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id,
                'sup_id'=>$ruas->data_sup->id,
                'kota_id'=>$ruas->kota_id,
                'sup'=>$ruas->data_sup->name,
                'uptd_id'=>$ruas->uptd_id,
                'tanggal'=> $request->tanggal,
                'kategori'=> $request->kategori,
                'kategori_kedalaman'=> $request->kategori_kedalaman,
                'panjang'=> $request->panjang,
                'description'=>$request->description,
                'lajur'=>$request->lajur,
                'potensi_lubang'=>$request->potensi_lubang,
            ];
            if($request->kategori == "Group"){
                $temporari['jumlah'] = $request->jumlah;
                $temporari['icon'] = 'sapulobang/sapulobang.png';
                $temporari['keterangan'] = 'Lubang Group';

            }
            if($request->file('image')){
                $image = $request->file('image');
                $image->storeAs('public/survei_lubang',$image->hashName());
                $temporari['image'] = $image->hashName();
            }
            $survei = SurveiLubang::firstOrNew($find);
            if(!$survei->id){
                $survei->uptd_id=$ruas->uptd_id;
                $survei->lat = $request->lat;
                $survei->long = $request->long;
                $survei->created_by = Auth::user()->id;
                $survei->save();
            }
            
            if($request->potensi_lubang == "false"){
                
                if(Str::contains($desc, 'tambah')){   
                    if($survei->id){
                        $survei->SurveiLubangDetail()->create($temporari);
                        // $survei->jumlah = $survei->jumlah + 1;
                        $survei->jumlah = $survei->SurveiLubangDetail->sum('jumlah');
                        $survei->panjang = $survei->SurveiLubangDetail->sum('panjang');
                    }
                    // $survei->jumlah = $survei->jumlah + $request->jumlah;
                }else{
                    
                    if($survei->SurveiLubangDetail()->where('kategori','Single')->count()>=1){
                        $del = $survei->SurveiLubangDetail()->where('kategori','Single')->first();  
                        if($del->image){
                            Storage::delete('public/survei_lubang/'.$del->image);
                        }
                        $del->delete();
                        // $survei->jumlah = $survei->jumlah - 1;
                        $survei->jumlah = $survei->SurveiLubangDetail->sum('jumlah');
                        $survei->panjang = $survei->SurveiLubangDetail->sum('panjang');
    
                    }else{
                        $this->response['data']['error'] = "Silahkan klik tambah!";
                        return response()->json($this->response, 200);
                    }
                    // $survei->jumlah = $survei->jumlah - $request->jumlah;
                }
                
                if(Str::contains($desc, 'tambah')){
                    if(!$survei->SurveiLubangDetail()->exists()){
                        if($request->kategori == "Group"){
                            $survei->jumlah = $request->jumlah;
                        }else
                            $survei->jumlah = 1;
    
                        $survei->panjang = $request->panjang;
                    }
                }
                $survei->save();
                $survei->ruas = $survei->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
                // storeLogActivity(declarLog(1, 'Survei Lubang', $ruas->nama_ruas_jalan,1));
                if(Str::contains($desc, 'tambah')){
                    if($survei->SurveiLubangDetail->count()==0){
                        $survei->SurveiLubangDetail()->create($temporari);      
                    }
                }else{
                    $cross_check = SurveiLubang::find($survei->id);
                    if($cross_check->jumlah != $cross_check->SurveiLubangDetail->sum('jumlah') || $cross_check->panjang != $cross_check->SurveiLubangDetail->sum('panjang')){
                       $cross_check->jumlah = $cross_check->SurveiLubangDetail->sum('jumlah');
                       $cross_check->panjang = $cross_check->SurveiLubangDetail->sum('panjang');
                       $cross_check->save();
                       $survei->jumlah = $cross_check->jumlah;
                    }
                }      
            }else{
                
                $find['monitoring_lubang_survei_id'] = $survei->id;
                $potensi = SurveiPotensiLubang::firstOrNew($find);
                $temporari['monitoring_lubang_survei_id'] = $survei->id;

                if(Str::contains($desc, 'tambah')){   
                    if($potensi->id){
                        $potensi->SurveiPotensiLubangDetail()->create($temporari);
                        // $potensi->jumlah = $potensi->jumlah + 1;
                        $potensi->jumlah = $potensi->SurveiPotensiLubangDetail->sum('jumlah');
                        $potensi->panjang = $potensi->SurveiPotensiLubangDetail->sum('panjang');
                    }
                    // $potensi->jumlah = $potensi->jumlah + $request->jumlah;
                }else{
                    
                    if($potensi->SurveiPotensiLubangDetail()->where('kategori','Single')->count()>=1){
                        $del = $potensi->SurveiPotensiLubangDetail()->where('kategori','Single')->first();  
                        if($del->image){
                            Storage::delete('public/survei_lubang/'.$del->image);
                        }
                        $del->delete();
                        // $potensi->jumlah = $potensi->jumlah - 1;
                        $potensi->jumlah = $potensi->SurveiPotensiLubangDetail->sum('jumlah');
                        $potensi->panjang = $potensi->SurveiPotensiLubangDetail->sum('panjang');
    
                    }else{
                        $this->response['data']['error'] = "Silahkan klik tambah!";
                        return response()->json($this->response, 200);
                    }
                    // $potensi->jumlah = $potensi->jumlah - $request->jumlah;
                }
                $potensi->uptd_id=$ruas->uptd_id;
                $potensi->lat = $request->lat;
                $potensi->long = $request->long;
                $potensi->monitoring_lubang_survei_id = $survei->id;
                $potensi->created_by = Auth::user()->id;
                if(Str::contains($desc, 'tambah')){
                    if(!$potensi->SurveiPotensiLubangDetail()->exists()){
                        if($request->kategori == "Group"){
                            $potensi->jumlah = $request->jumlah;
                        }else
                            $potensi->jumlah = 1;
    
                        $potensi->panjang = $request->panjang;
                    }
                }
                $potensi->save();
                $potensi->ruas = $potensi->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
                // storeLogActivity(declarLog(1, 'Survei Lubang', $ruas->nama_ruas_jalan,1));
                if(Str::contains($desc, 'tambah')){
                    if($potensi->SurveiPotensiLubangDetail->count()==0){
                        $potensi->SurveiPotensiLubangDetail()->create($temporari);      
                    }
                }else{
                    $cross_check = SurveiPotensiLubang::find($potensi->id);
                    if($cross_check->jumlah != $cross_check->SurveiPotensiLubangDetail->sum('jumlah') || $cross_check->panjang != $cross_check->SurveiPotensiLubangDetail->sum('panjang')){
                       $cross_check->jumlah = $cross_check->SurveiPotensiLubangDetail->sum('jumlah');
                       $cross_check->panjang = $cross_check->SurveiPotensiLubangDetail->sum('panjang');
                       $cross_check->save();
                       $potensi->jumlah = $cross_check->jumlah;
                    }
                }   
            }
            
            $survei->lokasi_km = $request->lokasi_km;
            $survei->lokasi_m = $request->lokasi_m;
            $survei->SurveiLubangDetail;
            $survei->SurveiPotensiLubangDetail;
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menambahkan',
                'data' => $survei,  
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function resultSurvei(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(1, 'Survei Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            
            if(!isset($ruas)){   
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
            $find = [
                'tanggal'=> $request->tanggal,
                'created_by' =>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id,
                'sup_id'=>$ruas->data_sup->id
            ];

            $survei = SurveiLubang::where($find)->first();
            $potensi = SurveiPotensiLubang::where($find)->first();
            
            if(isset($survei)){
                $survei->jumlah = $survei->SurveiLubangDetail->sum('jumlah');
                $survei->ruas = $survei->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
                $survei->SurveiPotensiLubangDetail;

            }else{
                $survei =([
                    'jumlah'=>0,
                    'tanggal'=>$request->tanggal,
                    'ruas_jalan_id'=>$request->ruas_jalan_id,
                    'ruas'=>$ruas->select('id_ruas_jalan','nama_ruas_jalan')->where('id_ruas_jalan',$request->ruas_jalan_id)->get(),
                    'survei_lubang_detail'=>[],
                    'survei_potensi_lubang_detail'=>[]

                ]);
            }
            if(isset($potensi)){
                $potensi->jumlah = $potensi->SurveiPotensiLubangDetail->sum('jumlah');
                $potensi->ruas = $potensi->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
            }else{
                $potensi =([
                    'jumlah'=>0,
                    'tanggal'=>$request->tanggal,
                    'ruas_jalan_id'=>$request->ruas_jalan_id,
                    'ruas'=>$ruas->select('id_ruas_jalan','nama_ruas_jalan')->where('id_ruas_jalan',$request->ruas_jalan_id)->get(),
                    'survei_potensi_lubang_detail'=>[]
                ]);
            }

            // $survei->survei_lubang_detail = $survei->SurveiLubangDetail()->whereNull('status');
            return response()->json([
                'success' => true,
                'data' => $survei

            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function deleteSurvei(Request $request, $id)
    {
        try {
            $data = SurveiLubangDetail::find($id);
            if($data->status == "Perencanaan" || $data->status == "Selesai"){
                if($data->status == "Selesai"){
                    //penanganan
                    $penanganan_detail = $data->DetailPenanganan;
                    $penanganan = $penanganan_detail->PenangananLubang;
                    $penanganan->jumlah = $penanganan->jumlah - $penanganan_detail->jumlah;
                    $penanganan->panjang = $penanganan->panjang - $penanganan_detail->panjang;
                    $penanganan_detail->delete();
                    $penanganan->save();
                }
                //perencanaan
                $rencana_detail = $data->DetailRencana;
                $rencana = $rencana_detail->RencanaPenangananLubang;
                $rencana->jumlah = $rencana->jumlah - $rencana_detail->jumlah;
                $rencana->panjang = $rencana->panjang - $rencana_detail->panjang;
                $rencana_detail->delete();
                $rencana->save();
            }
            $survei = $data->SurveiLubang;
            $survei->jumlah = $survei->jumlah - $data->jumlah;
            $survei->panjang = $survei->panjang - $data->panjang;
            $data->delete();
            $survei->save();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Data Survei', 
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function deletePotensi(Request $request, $id)
    {
        try {
            $data = SurveiPotensiLubangDetail::find($id);
           
            $survei_potensi = $data->SurveiPotensiLubang;
            $survei_potensi->jumlah = $survei_potensi->jumlah - $data->jumlah;
            $survei_potensi->panjang = $survei_potensi->panjang - $data->panjang;
            $data->delete();
            $survei_potensi->save();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Data Survei Potensi Lubang', 
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function indexPenanganan()
    {
        try {
            $filter['tanggal_awal'] = Carbon::now()->subDays(14)->format('Y-m-d');
            $filter['tanggal_akhir'] = Carbon::now()->format('Y-m-d');
            $data = PenangananLubang::whereBetween('tanggal', [$filter['tanggal_awal'], $filter['tanggal_akhir']])->latest('tanggal');
            if (Auth::user() && Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $data = $data->where('uptd_id', $uptd_id);
                if (str_contains(Auth::user()->internalRole->role, 'Mandor')) {
                    $data = $data->where('created_by', Auth::user()->id);
                } else if (Auth::user()->sup_id) {
                    $data = $data->where('sup_id', Auth::user()->sup_id);
                    if (count(Auth::user()->ruas) > 0) {
                        $data = $data->whereIn('ruas_jalan_id', Auth::user()->ruas->pluck('id_ruas_jalan')->toArray());
                    }
                }
            }
            $data = $data->get();
            return response()->json([
                'success' => true,
                'message' => 'Data Penanganan',
                'data'  => $data
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function listPenanganan(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ruas_jalan_id' => 'required',
                'tanggal' => 'required|date',
                'lokasi_kode' => '',
                'lokasi_km' => '',
                'lokasi_m' => '',
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            $temp = [
                'tanggal' => $request->tanggal,
                'lokasi_km' => $request->lokasi_km,
                'lokasi_m' => $request->lokasi_m,
                'ruas_jalan_id' => $request->ruas_jalan_id
            ];
            $data = SurveiLubangDetail::where('ruas_jalan_id',$request->ruas_jalan_id)->where('tanggal_rencana_penanganan','<=',$request->tanggal)->where('status','Perencanaan')->latest('updated_at')->get();
            $data1 = SurveiLubangDetail::where('ruas_jalan_id',$request->ruas_jalan_id)->where('tanggal','<=',$request->tanggal)->where('status','Selesai')->latest('updated_at')->get();

            if(isset($data)){
                return response()->json([
                    'success' => true,
                    'message' => 'Data Penanganan',
                    'data'  => $data,
                    'data_selesai'  => $data1,
                    'data_support'  => $temp,
                ]);

            }else{
                $this->response['data']['error'] = "Ruas ini sudah tidak ada yang bisa di tangani";
                return response()->json($this->response, 200);
            }
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function executePenanganan(Request $request, $id, $tanggal)
    {
        try {
            $validator = Validator::make($request->all(), [
                'keterangan' => '',
                'image_penanganan' => '',
                'lat' => '',
                'long' => '',
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            $temp = [
                'status'=>"Selesai",
                'updated_by'=>Auth::user()->id,
                'tanggal_penanganan'=> $tanggal,
                'icon' => "sapulobang/sapulobang_finish.png",
                'keterangan' => 'Lubang Diperbaiki'
            ];
            if($request->file('image_penanganan')){
                $image_penanganan = $request->file('image_penanganan');
                $image_penanganan->storeAs('public/survei_lubang',$image_penanganan->hashName());
                $temp['image_penanganan'] = $image_penanganan->hashName();
            }
            $data = SurveiLubangDetail::findOrFail($id);
            $ruas = RuasJalan::where('id_ruas_jalan',$data->ruas_jalan_id)->first();
            

            $theta = $data->long - $request->long;
            $miles = (sin(deg2rad($data->lat)) * sin(deg2rad($request->lat))) + (cos(deg2rad($data->lat)) * cos(deg2rad($request->lat)) * cos(deg2rad($theta)));
            $miles = acos($miles);
            $miles = rad2deg($miles);
            $miles = $miles * 60 * 1.1515;
            $feet  = $miles * 5280;
            $yards = $feet / 3;
            $kilometers = $miles * 1.609344;
            $meters = $kilometers * 1000;

            if($data){
                if($meters <=3){
                    $data->update($temp);
                    $temp = [
                        'tanggal' => $tanggal,
                        'lokasi_km' => $request->lokasi_km,
                        'lokasi_m' => $request->lokasi_m,
                        'ruas_jalan_id' => $data->ruas_jalan_id
                    ];
                    $penanganan = PenangananLubang::firstOrNew([
                        'tanggal'=> $tanggal,
                        'created_by' =>Auth::user()->id,
                        'ruas_jalan_id'=>$data->ruas_jalan_id,
                        'sup_id'=>$ruas->data_sup->id,
                    ]);
                    
                    $penanganan->uptd_id=$ruas->uptd_id;
                    
                    if($penanganan->id){
                        $penanganan->jumlah += $data->jumlah;
                        $penanganan->panjang += $data->panjang;
                    }else{
                        $penanganan->jumlah= $data->jumlah;
                        $penanganan->panjang= $data->panjang;
                    }
                    $penanganan->save();
                    
                    $penanganan->PenangananLubangDetail()->create([
                        'tanggal'=> $tanggal,
                        'created_by' =>Auth::user()->id,
                        'ruas_jalan_id'=>$data->ruas_jalan_id,
                        'sup_id'=>$ruas->data_sup->id,
                        'uptd_id'=>$ruas->uptd_id,
                        'monitoring_lubang_survei_detail_id'=>$data->id,
                        'keterangan' => $request->keterangan,
                        'kategori'=>$data->kategori,
                        'jumlah'=>$data->jumlah,
                        'panjang'=>$data->panjang,
    
                    ]);
                    storeLogActivity(declarLog(2, 'Penanganan Lubang', '',1));
                    $data2 = SurveiLubangDetail::where('ruas_jalan_id',$data->ruas_jalan_id)->where('tanggal_rencana_penanganan','<=',$tanggal)->where('status','Perencanaan')->latest()->get();
                    $data1 = SurveiLubangDetail::where('ruas_jalan_id',$data->ruas_jalan_id)->where('tanggal','<=',$tanggal)->where('status','Selesai')->latest()->get();
    
                    if(isset($data)){
                        return response()->json([
                            'success' => true,
                            'message' => 'Berhasil Merubah Status Lubang',
                            'data'  => $data2,
                            'data_selesai'  => $data1,
                            'data_support'  => $temp,
                        ]);
    
                    }else{
                        $this->response['data']['error'] = "Data tidak ditemukan";
                        return response()->json($this->response, 400);
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'Ruas ini sudah tiadak ada yang bisa di tangani',
                    ]);
                }else{
                    $this->response['data']['error'] = "Jarak anda terlalu jauh, Maksimal 3 meter";
                    return response()->json($this->response, 400);
                }
                
            }else{
                $this->response['data']['message'] = 'Data tidak ditemukan';
                return response()->json($this->response, 500);
            }
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function storePenanganan(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah' => 'required',
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
                'keterangan' => ''
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(1, 'Penanganan Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            if(!isset($ruas)){   
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
            $temp =([
                'tanggal'=>$request->tanggal,
                'created_by'=>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id,
                'sup_id'=>$ruas->data_sup->id,
                'uptd_id'=>$ruas->uptd_id,
                'jumlah'=>$request->jumlah,
                'keterangan'=>$request->keterangan,
            ]);
            $penanganan = PenangananLubang::create($temp);
            storeLogActivity(declarLog(1, 'Penanganan Lubang', $ruas->nama_ruas_jalan,1));
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menambahkan Penanganan',
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function editPenanganan($id)
    {
        try {
            $data = PenangananLubang::find($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Penanganan',
                'data'  => $data
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function updatePenanganan(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah' => 'required',
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
                'keterangan' => ''
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(2, 'Penanganan Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            if(!isset($ruas)){   
                storeLogActivity(declarLog(2, 'Penanganan Lubang', 'Ruas Tidak Ditemukan'));
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
            $temp = [
                "jumlah"=>$request->jumlah, 
                "tanggal"=>$request->tanggal,
                "ruas_jalan_id"=>$request->ruas_jalan_id,
                "keterangan"=>$request->keterangan,
            ];
            $data = PenangananLubang::findOrFail($id)->update($temp);
            if($data){
                storeLogActivity(declarLog(2, 'Penanganan Lubang', $ruas->nama_ruas_jalan,1));
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Merubah Penanganan',
                ]);
            }else{
                storeLogActivity(declarLog(2, 'Penanganan Lubang', 'Data Tidak Ditemukan'));
                $this->response['data']['error'] = "Data Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
        
    }

    public function indexRencanaPenanganan()
    {
        try {
            $filter['tanggal_awal'] = Carbon::now()->subDays(14)->format('Y-m-d');
            $filter['tanggal_akhir'] = Carbon::now()->format('Y-m-d');
            $data = RencanaPenanganan::whereBetween('tanggal', [$filter['tanggal_awal'], $filter['tanggal_akhir']])->latest('tanggal');
            if (Auth::user() && Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $data = $data->where('uptd_id', $uptd_id);
                if (str_contains(Auth::user()->internalRole->role, 'Mandor')) {
                    $data = $data->where('created_by', Auth::user()->id);
                } else if (Auth::user()->sup_id) {
                    $data = $data->where('sup_id', Auth::user()->sup_id);
                    if (count(Auth::user()->ruas) > 0) {
                        $data = $data->whereIn('ruas_jalan_id', Auth::user()->ruas->pluck('id_ruas_jalan')->toArray());
                    }
                }
            }
            $data = $data->get();
            return response()->json([
                'success' => true,
                'message' => 'Data Penanganan',
                'data'  => $data
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function storeRencanaPenanganan(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah' => 'required',
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
                'keterangan' => ''
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(1, 'Rencana Penanganan Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            if(!isset($ruas)){   
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
            $temp =([
                'tanggal'=>$request->tanggal,
                'created_by'=>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id,
                'sup_id'=>$ruas->data_sup->id,
                'uptd_id'=>$ruas->uptd_id,
                'jumlah'=>$request->jumlah,
                'keterangan'=>$request->keterangan,
            ]);
            $penanganan = RencanaPenanganan::create($temp);
            storeLogActivity(declarLog(1, 'Rencana Penanganan Lubang', $ruas->nama_ruas_jalan,1));
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menambahkan Penanganan',
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function editRencanaPenanganan($id)
    {
        try {
            $data = RencanaPenanganan::find($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Penanganan',
                'data'  => $data
            ]);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    public function updateRencanaPenanganan(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah' => 'required',
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required',
                'keterangan' => ''
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                storeLogActivity(declarLog(2, 'Penanganan Lubang', $validator->errors()));
                return response()->json($this->response, 200);
            }
            $ruas = RuasJalan::where('id_ruas_jalan',$request->ruas_jalan_id)->first();
            if(!isset($ruas)){   
                storeLogActivity(declarLog(2, 'Penanganan Lubang', 'Ruas Tidak Ditemukan'));
                $this->response['data']['error'] = "Ruas Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
            $temp = [
                "jumlah"=>$request->jumlah, 
                "tanggal"=>$request->tanggal,
                "ruas_jalan_id"=>$request->ruas_jalan_id,
                "keterangan"=>$request->keterangan,
            ];
            $data = RencanaPenanganan::findOrFail($id)->update($temp);
            if($data){
                storeLogActivity(declarLog(2, 'Penanganan Lubang', $ruas->nama_ruas_jalan,1));
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Merubah Penanganan',
                ]);
            }else{
                storeLogActivity(declarLog(2, 'Rencana Penanganan Lubang', 'Data Tidak Ditemukan'));
                $this->response['data']['error'] = "Data Tidak Ditemukan";
                return response()->json($this->response, 200);
            }
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }  
    }
    public function listRencanaPenanganan(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ruas_jalan_id' => 'required',
                'tanggal' => 'required|date',
                'lokasi_kode' => '',
                'lokasi_km' => '',
                'lokasi_m' => '',
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            $temp = [
                'tanggal' => $request->tanggal,
                'lokasi_km' => $request->lokasi_km,
                'lokasi_m' => $request->lokasi_m,
                'ruas_jalan_id' => $request->ruas_jalan_id

            ];
            $data = SurveiLubangDetail::where('ruas_jalan_id',$request->ruas_jalan_id)->where('tanggal','<=',$request->tanggal)->whereNull('status')->latest()->get();
            $data1 = SurveiLubangDetail::where('ruas_jalan_id',$request->ruas_jalan_id)->where('tanggal','<=',$request->tanggal)->where('status','Perencanaan')->latest('updated_at')->get();

            if(isset($data)){
                return response()->json([
                    'success' => true,
                    'message' => 'Data Rencana Penanganan',
                    'data'  => $data,
                    'data_perencanaan'  => $data1,
                    'data_support'  => $temp,
                ]);

            }else{
                $this->response['data']['error'] = "Ruas ini tidak ada yang bisa di rencanakan";
                return response()->json($this->response, 200);
            }
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }
    public function executeRencanaPenanganan(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'keterangan' => '',
                'tanggal' =>'required'
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            $temp = [
                "status"=>"Perencanaan",
                "updated_by"=>Auth::user()->id,
                'tanggal_rencana_penanganan'=> $request->tanggal,
                'icon' => "sapulobang/sapulobang_schedule.png",
                'keterangan' => 'Lubang Dalam Perencanaan'
            ];
            $data = SurveiLubangDetail::findOrFail($id);
            $ruas = RuasJalan::where('id_ruas_jalan',$data->ruas_jalan_id)->first();
            
            if($data){
                $data->update($temp);
                $temp = [
                    'tanggal' => $request->tanggal,
                    'lokasi_km' => $request->lokasi_km,
                    'lokasi_m' => $request->lokasi_m,
                    'ruas_jalan_id' => $data->ruas_jalan_id

                ];
                
                $rencana_penanganan = RencanaPenanganan::firstOrNew([
                    'tanggal'=> $request->tanggal,
                    'created_by' =>Auth::user()->id,
                    'ruas_jalan_id'=>$data->ruas_jalan_id,
                    'sup_id'=>$ruas->data_sup->id,
                ]);
                $rencana_penanganan->uptd_id=$ruas->uptd_id;
                if($rencana_penanganan->id){
                    // $rencana_penanganan->jumlah=$rencana_penanganan->jumlah + 1;
                    $rencana_penanganan->jumlah += $data->jumlah;
                    $rencana_penanganan->panjang += $data->panjang;
                }else{
                    $rencana_penanganan->jumlah= $data->jumlah;
                    $rencana_penanganan->panjang= $data->panjang;
                }
                
                $rencana_penanganan->save();
                
                $rencana_penanganan->RencanaPenangananLubangDetail()->create([
                    'tanggal'=> $request->tanggal,
                    'created_by' =>Auth::user()->id,
                    'ruas_jalan_id'=>$data->ruas_jalan_id,
                    'sup_id'=>$ruas->data_sup->id,
                    'uptd_id'=>$ruas->uptd_id,
                    'monitoring_lubang_survei_detail_id'=>$data->id,
                    'keterangan' => $request->keterangan,
                    'kategori'=>$data->kategori,
                    'jumlah'=>$data->jumlah,
                    'panjang'=>$data->panjang,

                ]);
                
                storeLogActivity(declarLog(2, 'Rencana Penanganan Lubang', $ruas->nama_ruas_jalan,1));
                $data2 = SurveiLubangDetail::where('ruas_jalan_id',$data->ruas_jalan_id)->where('tanggal','<=',$request->tanggal)->whereNull('status')->latest()->get();
                $data1 = SurveiLubangDetail::where('ruas_jalan_id',$data->ruas_jalan_id)->where('tanggal','<=',$request->tanggal)->where('status','Perencanaan')->latest('updated_at')->get();
                if(isset($data)){
                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil Merubah Status Lubang Dalam Perencanaan',
                        'data'  => $data2,
                        'data_perencanaan'  => $data1,
                        'data_support'  => $temp,
                    ]);
                }else{
                    $this->response['data']['error'] = "Data tidak ditemukan";
                    return response()->json($this->response, 200);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Ruas ini sudah tiadak ada yang bisa di rencanakan',
                ]);
            }else{
                $this->response['data']['message'] = 'Data tidak ditemukan';
                return response()->json($this->response, 500);
            }
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
        
    }

    // try {
    // } catch (\Exception $th) {
    //     $this->response['data']['message'] = 'Internal Error';
    //     return response()->json($this->response, 500);
    // }


}
