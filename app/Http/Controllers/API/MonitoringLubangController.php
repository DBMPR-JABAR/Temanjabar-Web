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
                $survei->jumlah = $survei->SurveiLubangDetail->count();
                $survei->ruas = $survei->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
            }else{
                $survei =([
                    'jumlah'=>0,
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
            $survei = SurveiLubang::firstOrNew([
                'tanggal'=> $request->tanggal,
                'created_by' =>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id,
                'sup_id'=>$ruas->data_sup->id,
                'lokasi_kode' => Str::upper($request->lokasi_kode),

            ]);
            if(Str::contains($desc, 'tambah')){
               
                if($survei->id){
                    $survei->SurveiLubangDetail()->create([
                        'lat' => $request->lat,
                        'long' => $request->long,
                        'lokasi_km' => $request->lokasi_km,
                        'lokasi_m' => $request->lokasi_m,
                        'created_by' =>Auth::user()->id,
                        'ruas_jalan_id'=>$request->ruas_jalan_id,
                        'sup_id'=>$ruas->data_sup->id,
                        'uptd_id'=>$ruas->uptd_id,
                        'tanggal'=> $request->tanggal,


                    ]);
                    // $survei->jumlah = $survei->jumlah + 1;
                    $survei->jumlah = $survei->SurveiLubangDetail->count();
                }
                // $survei->jumlah = $survei->jumlah + $request->jumlah;
            }else{
                if($survei->SurveiLubangDetail->count()>=1){
                    $del = $survei->SurveiLubangDetail()->first();
                    $del->delete();
                    // $survei->jumlah = $survei->jumlah - 1;
                    $survei->jumlah = $survei->SurveiLubangDetail->count();
                }else{
                    $this->response['data']['error'] = "Silahkan klik tambah!";
                    return response()->json($this->response, 200);
                }
                // $survei->jumlah = $survei->jumlah - $request->jumlah;
            }
            $survei->uptd_id=$ruas->uptd_id;
            $survei->lat = $request->lat;
            $survei->long = $request->long;
            $survei->created_by = Auth::user()->id;
            
            if(!$survei->SurveiLubangDetail()->exists()){
                $survei->jumlah = 1;
            }
           
            $survei->save();
            
            // storeLogActivity(declarLog(1, 'Survei Lubang', $ruas->nama_ruas_jalan,1));
            if(Str::contains($desc, 'tambah')){
                if($survei->SurveiLubangDetail->count()==0){
                    $survei->SurveiLubangDetail()->create([
                        'lat' => $request->lat,
                        'long' => $request->long,
                        'lokasi_km' => $request->lokasi_km,
                        'lokasi_m' => $request->lokasi_m,
                        'created_by' =>Auth::user()->id,
                        'ruas_jalan_id'=>$request->ruas_jalan_id,
                        'sup_id'=>$ruas->data_sup->id,
                        'tanggal'=> $request->tanggal,
                        'uptd_id'=>$ruas->uptd_id,

                    ]);
                    
                }

            }else{
                

            }
            $cross_chesck = SurveiLubang::find($survei->id);
            if($cross_chesck->jumlah != $cross_chesck->SurveiLubangDetail->count()){
                $cross_chesck->jumlah = $cross_chesck->SurveiLubangDetail->count();
                $cross_chesck->save();
            }
            $cross_chesck->ruas = $cross_chesck->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
            $cross_chesck->lokasi_km = $request->lokasi_km;
            $cross_chesck->lokasi_m = $request->lokasi_m;
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menambahkan',
                'data' => $cross_chesck,  
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
            ];
            $data = SurveiLubangDetail::where('ruas_jalan_id',$request->ruas_jalan_id)->where('tanggal','<=',$request->tanggal)->whereNull('status')->latest()->get();
            if(isset($data)){
                return response()->json([
                    'success' => true,
                    'message' => 'Data Penanganan',
                    'data'  => $data,
                    'data_support'  => $temp,
                ]);

            }else{
                $this->response['data']['error'] = "Data tidak ditemukan";
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
                'keterangan' => ''
            ]);
            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            $temp = [
                "status"=>"Selesai",
                'updated_by'=>Auth::user()->id
            ];
            $data = SurveiLubangDetail::findOrFail($id);
            
            $ruas = RuasJalan::where('id_ruas_jalan',$data->ruas_jalan_id)->first();
            
            if($data){
                
    
                $data->update($temp);
                $penanganan = PenangananLubang::firstOrNew([
                    'tanggal'=> $tanggal,
                    'created_by' =>Auth::user()->id,
                    'ruas_jalan_id'=>$data->ruas_jalan_id,
                    'sup_id'=>$ruas->data_sup->id,
                ]);
                
                $penanganan->uptd_id=$ruas->uptd_id;
                
                if($penanganan->id){
                    // $penanganan->jumlah=$penanganan->jumlah + 1;
                    
                    $penanganan->jumlah = $penanganan->PenangananLubangDetail->count();
                }else{
                    $penanganan->jumlah=1;
                }
                $penanganan->save();
                
                $penanganan->PenangananLubangDetail()->create([
                    'tanggal'=> $tanggal,
                    'created_by' =>Auth::user()->id,
                    'ruas_jalan_id'=>$ruas->ruas_jalan_id,
                    'sup_id'=>$ruas->data_sup->id,
                    'uptd_id'=>$ruas->uptd_id,
                    'monitoring_lubang_survei_detail_id'=>$data->id,
                    'keterangan' => $request->keterangan

                ]);
                storeLogActivity(declarLog(2, 'Penanganan Lubang', '',1));
                $data = SurveiLubangDetail::where('ruas_jalan_id',$data->ruas_jalan_id)->where('tanggal','<=',$tanggal)->whereNull('status')->latest()->get();
                if(isset($data)){
                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil Merubah Status Lubang',
                        'data_support'  => $temp,
                        'data'  => $data,
                    ]);

                }else{
                    $this->response['data']['error'] = "Data tidak ditemukan";
                    return response()->json($this->response, 200);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Ruas ini sudah tiadak ada yang bisa di tangani',
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
    // try {
    // } catch (\Exception $th) {
    //     $this->response['data']['message'] = 'Internal Error';
    //     return response()->json($this->response, 500);
    // }

}
