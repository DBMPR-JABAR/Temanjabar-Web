<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Model\Transactional\MonitoringLubangSurvei as SurveiLubang;
use App\Model\Transactional\monitoring_lubang_penanganan as PenangananLubang;

class MonitoringLubangController extends Controller
{
    //
    public function storeSurvei(Request $request, $desc)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah' => '',
                'tanggal' => 'required|date',
                'ruas_jalan_id' => 'required'
            ]);

            if ($validator->fails()) {
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 200);
            }
            
            $survei = SurveiLubang::firstOrNew([
                'tanggal'=> $request->tanggal,
                'created_by' =>Auth::user()->id,
                'ruas_jalan_id'=>$request->ruas_jalan_id
            ]);
            
            if(Str::contains($desc, 'tambah')){
                $survei->jumlah = $survei->jumlah + 1;
                // $survei->jumlah = $survei->jumlah + $request->jumlah;
            }else{
                $survei->jumlah = $survei->jumlah - 1;
                // $survei->jumlah = $survei->jumlah - $request->jumlah;
            }
            $survei->created_by = Auth::user()->id;
            $survei->save();
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
}
