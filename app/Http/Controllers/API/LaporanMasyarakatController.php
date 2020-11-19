<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transactional\LaporanMasyarakat;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ProgressLaporanResource;
use App\Http\Resources\StatusLaporanResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaporanMasyarakatController extends Controller
{
    private $response;
    public function __construct() {
        $this->response = [
            'status' => 'false',
            'data' => []
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has("skip")){
            return (new GeneralResource(LaporanMasyarakat::skip($request->skip)->take($request->take)->get()));
        }
        return (new GeneralResource(LaporanMasyarakat::all()));
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
            $laporanMasyarakat = new LaporanMasyarakat;
            $laporanMasyarakat->fill($request->except(['gambar']));
            if($request->gambar != null){
                $path = 'laporan_masyarakat/'.date("YmdHis").'_'.$request->gambar->getClientOriginalName();
                $request->gambar->storeAs('public/',$path);
                $laporanMasyarakat['gambar'] = url('storage/'.$path);
            }
            $laporanMasyarakat->status = 'Submitted';
            $laporanMasyarakat->save();
            $this->response['status'] = 'success';
            $this->response['data']['id'] = $laporanMasyarakat->id;
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
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
        return new GeneralResource(LaporanMasyarakat::findOrFail($id));
    }

    public function getPetugas()
    {
        try {
            $data = DB::table('user_pegawai')->get();

            $this->response['status'] = 'success';
            $this->response['data'] = $data;
            return response()->json($this->response, 200);
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getOnProgress($id)
    {
        try {
            $data = DB::table('monitoring_laporan_petugas')->where('laporan_id',$id)->get();
            return (ProgressLaporanResource::collection($data)->additional(['status' => 'success']));
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getListLaporan($status)
    {
        try {
            $data = LaporanMasyarakat::where('status',$status)->get();
            return (StatusLaporanResource::collection($data)->additional(['status' => 'success']));
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getJenisLaporan()
    {
        try {
            $jenis = DB::table('utils_jenis_laporan')->get();

            $this->response['status'] = 'success';
            $this->response['data'] = $jenis;
            return response()->json($this->response, 200);
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getNotifikasi()
    {
        try {
            $data = DB::table('utils_notifikasi')->where('user_id',auth('api')->user()->id)
                                                 ->orderBy('created_at','desc')->get();
            return (NotificationResource::collection($data)->additional(['status' => 'success']));
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getUPTD()
    {
        try {
            $lokasi = DB::table('landing_uptd')->get();

            $this->response['status'] = 'success';
            $this->response['data'] = $lokasi;
            return response()->json($this->response, 200);
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getLokasi()
    {
        try {
            $lokasi = DB::table('utils_lokasi')->get();

            $this->response['status'] = 'success';
            $this->response['data'] = $lokasi;
            return response()->json($this->response, 200);
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
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
        //
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
}
