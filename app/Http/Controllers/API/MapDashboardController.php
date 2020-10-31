<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DWH\Pembangunan;
use App\Model\DWH\RuasJalan;
use App\Model\DWH\Kemandoran;
use App\Model\DWH\ProgressMingguan;
use App\Model\DWH\Jembatan;

class MapDashboardController extends Controller
{
    private $response;
    public function __construct() {
        $this->response = [
            'status' => 'false',
            'data' => []
        ];
    }
    public function getSUP(Request $request)
    {
        try {
            $sup = RuasJalan::select('SUP')->whereIn('UPTD',$request->uptd)->distinct()->get();

            $this->response['status'] = 'success';
            $this->response['data']['sup'] = $sup;

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getData(Request $request)
    {
        try {
            $sup = RuasJalan::select('SUP')->whereIn('UPTD',$request->uptd)->distinct()->get();
            $this->response['status'] = 'success';
            $this->response['data']['jembatan'] = [];
            $this->response['data']['ruasjalan'] = [];
            $this->response['data']['pembangunan'] = [];
            $this->response['data']['peningkatan'] = [];
            $this->response['data']['pemeliharaan'] = [];
            $this->response['data']['rehabilitasi'] = [];
            $this->response['data']['progressmingguan'] = [];

            $this->response['data']['sup'] = $sup;
            if ($request->has('kegiatan')) {
                if(in_array('jembatan', $request->kegiatan)){
                    $data = Jembatan::whereIn('UPTD',$request->uptd)->get();
                    $this->response['data']['jembatan'] = $data;
                }
                if(in_array('pembangunan', $request->kegiatan)){
                    $data = Pembangunan::whereIn('UPTD',$request->uptd)->where('KATEGORI','LIKE','pb%')->get();
                    $this->response['data']['pembangunan'] = $data;
                }
                if(in_array('peningkatan', $request->kegiatan)){
                    $data = Pembangunan::whereIn('UPTD',$request->uptd)->where('KATEGORI','LIKE','pn%')->get();
                    $this->response['data']['peningkatan'] = $data;
                }
                if(in_array('rehabilitasi', $request->kegiatan)){
                    $data = Pembangunan::whereIn('UPTD',$request->uptd)->where('KATEGORI','LIKE','rb%')->get();
                    $this->response['data']['rehabilitasi'] = $data;
                }
                if(in_array('pemeliharaan', $request->kegiatan)){
                    $data = Kemandoran::whereIn('UPTD',$request->uptd)->get();
                    $this->response['data']['rehabilitasi'] = $data;
                }
                if(in_array('ruasjalan', $request->kegiatan)){
                    $data = RuasJalan::whereIn('UPTD',$request->uptd)->get();
                    $this->response['data']['ruasjalan'] = $data;
                }
                if(in_array('progressmingguan', $request->kegiatan)){
                    $data = ProgressMingguan::all();
                    $this->response['data']['progressmingguan'] = $data;
                }
            }

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getDataProyek(Request $request)
    {
        try {
            $sup = RuasJalan::select('SUP')->whereIn('UPTD',$request->uptd)->distinct()->get();
            $this->response['status'] = 'success';
            $this->response['data']['jembatan'] = [];
            $this->response['data']['ruasjalan'] = [];
            $this->response['data']['pembangunan'] = [];
            $this->response['data']['peningkatan'] = [];
            $this->response['data']['pemeliharaan'] = [];
            $this->response['data']['rehabilitasi'] = [];
            $this->response['data']['progressmingguan'] = [];

            $this->response['data']['sup'] = $sup;
            if ($request->has('kegiatan')) {
                if(in_array('jembatan', $request->kegiatan)){
                    $data = Jembatan::whereIn('UPTD',$request->uptd)->get();
                    $this->response['data']['jembatan'] = $data;
                }
                if(in_array('pembangunan', $request->kegiatan)){
                    $data = Pembangunan::whereIn('UPTD',$request->uptd)->where('KATEGORI','LIKE','pb%')->get();
                    $this->response['data']['pembangunan'] = $data;
                }
                if(in_array('peningkatan', $request->kegiatan)){
                    $data = Pembangunan::whereIn('UPTD',$request->uptd)->where('KATEGORI','LIKE','pn%')->get();
                    $this->response['data']['peningkatan'] = $data;
                }
                if(in_array('rehabilitasi', $request->kegiatan)){
                    $data = Pembangunan::whereIn('UPTD',$request->uptd)->where('KATEGORI','LIKE','rb%')->get();
                    $this->response['data']['rehabilitasi'] = $data;
                }
                if(in_array('pemeliharaan', $request->kegiatan)){
                    $data = Kemandoran::whereIn('UPTD',$request->uptd)->get();
                    $this->response['data']['rehabilitasi'] = $data;
                }
                if(in_array('ruasjalan', $request->kegiatan)){
                    $data = RuasJalan::whereIn('UPTD',$request->uptd)->get();
                    $this->response['data']['ruasjalan'] = $data;
                }
            }
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }


    public function filter(Request $request)
    {
        try {
            $jembatan = Jembatan::whereIn('SUP',$request->sup)->get();

            $this->response['status'] = 'success';
            $this->response['data']['jembatan'] = $jembatan;
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
}
