<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DWH\Pembangunan;
use App\Model\DWH\RuasJalan;
use App\Model\DWH\Kemandoran;
use App\Model\DWH\ProgressMingguan;
// use App\Model\DWH\Jembatan;
use App\Model\Transactional\Jembatan;
use App\Model\DWH\VehicleCounting;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\MapJembatanResource;
use App\Model\DWH\KemantapanJalan;
use App\Model\Transactional\LaporanMasyarakat;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PDO;

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
            $sup = RuasJalan::select('SUP','UPTD')->whereIn('UPTD',$request->uptd)->distinct()->get();

            $this->response['status'] = 'success';

            $uptd = $request['uptd'];
            $this->response['data']['uptd'] =  $uptd;
            $this->response['data']['spp'] =  $sup;

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getJembatan(Request $request)
    {
        try {
            // $jembatan = (new MapJembatanResource());
            $jembatan = MapJembatanResource::collection(Jembatan::whereIn('UPTD',['uptd3'])->get());
            // $jembatan = Jembatan::whereIn('UPTD',['uptd1'])->get();
            $this->response['status'] = 'success';
            $this->response['data']['jembatan'] = $jembatan;

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function getData(Request $request)
    {
        try {
            if($request->kegiatan != "" || $request->sup != "") $this->response['status'] = 'success';
            $this->response['data']['jembatan'] = [];
            // $this->response['data']['ruasjalan'] = [];
            $this->response['data']['pembangunan'] = [];
            $this->response['data']['peningkatan'] = [];
            $this->response['data']['pemeliharaan'] = [];
            $this->response['data']['rehabilitasi'] = [];
            $this->response['data']['vehiclecounting'] = [];
            $this->response['data']['kemantapanjalan'] = [];

            if ($request->has('kegiatan')) {
                if(in_array('jembatan', $request->kegiatan)){
                    // $data = Jembatan::whereIn('SUP',$request->sup)->get();
                    $data = MapJembatanResource::collection(Jembatan::whereIn('SUP',$request->sup)->get());

                    $this->response['data']['jembatan'] = $data;
                }
                if(in_array('pembangunan', $request->kegiatan)){
                    $data = Pembangunan::whereIn('SUP',$request->sup)->where('KATEGORI','LIKE','pb%');

                    $data = $data->whereBetween('TGL_KONTRAK', [$request->date_from, $request->date_to]);

                    $data = $data->get();
                    $this->response['data']['pembangunan'] = $data;
                }
                if(in_array('peningkatan', $request->kegiatan)){
                    $data = Pembangunan::whereIn('SUP',$request->sup)->where('KATEGORI','LIKE','pn%');

                    $data = $data->whereBetween('TGL_KONTRAK', [$request->date_from, $request->date_to]);

                    $data = $data->get();
                    $this->response['data']['peningkatan'] = $data;
                }
                if(in_array('rehabilitasi', $request->kegiatan)){
                    $data = Pembangunan::whereIn('SUP',$request->sup)->where('KATEGORI','LIKE','rb%');

                    $data = $data->whereBetween('TGL_KONTRAK', [$request->date_from, $request->date_to]);

                    $data = $data->get();
                    $this->response['data']['rehabilitasi'] = $data;
                }
                if(in_array('pemeliharaan', $request->kegiatan)){
                    $data = Kemandoran::whereIn('SUP',$request->sup);

                    $data = $data->whereBetween('TANGGAL', [$request->date_from, $request->date_to]);

                    $data = $data->get();
                    $this->response['data']['pemeliharaan'] = $data;
                }
                // if(in_array('ruasjalan', $request->kegiatan)){
                //     $data = RuasJalan::whereIn('SUP',$request->sup)->get();
                //     $this->response['data']['ruasjalan'] = $data;
                // }
                // if(in_array('progressmingguan', $request->kegiatan)){
                //     $data = ProgressMingguan::whereIn('SUP',$request->sup)->get();
                //     $this->response['data']['progressmingguan'] = $data;
                // }
                if(in_array('vehiclecounting', $request->kegiatan)){
                    $data = VehicleCounting::whereIn('SUP',$request->sup)->get();
                    $this->response['data']['vehiclecounting'] = $data;
                }
                if(in_array('rawanbencana', $request->kegiatan)){
                    $data = DB::connection('dwh')->table('TBL_TMNJABAR_TRX_MASTER_RAWAN_BENCANA')
                            ->whereIn('SUP',$request->sup)->get();
                    $icon = DB::connection('dwh')->table('TBL_TMNJABAR_TRX_MASTER_RAWAN_BENCANA')->select('ICON_NAME','ICON_IMAGE')
                            ->whereIn('SUP',$request->sup)->whereNotNull('ICON_IMAGE')
                            ->groupBy('ICON_IMAGE')->get();
                    $this->response['data']['rawanbencana'] = $data;
                    $this->response['data']['iconrawanbencana'] = $icon;
                }
                if(in_array('cctv', $request->kegiatan)){
                    $data = DB::connection('dwh')->table('TBL_TMNJABAR_TRX_CCTV')
                            ->whereIn('SUP',$request->sup)->get();
                    $this->response['data']['cctv'] = $data;
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
            $jembatan = (new MapJembatanResource(Jembatan::whereIn('UPTD','uptd1')->get()));

            $this->response['status'] = 'success';
            $this->response['data']['jembatan'] = $jembatan;
            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function showLaporan()
    {
        return (new GeneralResource(LaporanMasyarakat::all()));
    }

    public function showKemantapanJalan()
    {
        return (new GeneralResource(KemantapanJalan::all()));
    }

    public function showPerbaikan(Request $request)
    {
        try {
            $lat = $request->lat;
            $long = $request->long;
            $notId = $request->exclude;

            // 100m Radius
            $qDistance = "(SQRT(POW(LNG - ($long), 2) + pow(LAT - ($lat), 2)) * 1.1 * 200 * 1000)";
            $data = DB::connection('dwh')->table('TBL_UPTD_TRX_PEMBANGUNAN')
                    ->select("KODE_PAKET AS ID","TGL_KONTRAK","WAKTU_PELAKSANAAN_HK", "LOKASI_PEKERJAAN AS RUAS_JALAN", "KEGIATAN", "LAT", "LNG", DB::raw("$qDistance AS DISTANCE"))
                    ->whereRaw("$qDistance <= 100");

            if($notId) $data = $data->whereNotIn("ID",$notId);

            $data = $data->orderBy("DISTANCE");

            $firstData = $data->first();
            if($firstData) {
            $date = Carbon::createFromFormat('Y-m-d', $firstData->TGL_KONTRAK);
            $daysToAdd = (float)$firstData->WAKTU_PELAKSANAAN_HK;
            $dateExpired = $date->addDays($daysToAdd);
            $firstData = Arr::except((array)$firstData, ['TGL_KONTRAK','WAKTU_PELAKSANAAN_HK']);
            if($dateExpired < Carbon::now()) $firstData = null;
            }
            $this->response['status'] = "success";
            $this->response['data'] = $firstData;
            return response()->json($this->response, 200);
        }catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error' .$th;
            return response()->json($this->response, 500);
        }
    }
}
