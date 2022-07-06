<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Transactional\RuasJalan;
use App\Model\Transactional\RuasJalanDetail;
use App\Model\Transactional\UPTD;
use App\Model\Transactional\Kota;
use App\talikuat\DataUmum;
use App\User;

use App\Model\Transactional\MonitoringLubangSurvei as SurveiLubang;
use App\Model\Transactional\MonitoringLubangSurveiDetail as SurveiLubangDetail;
use App\Model\Transactional\MonitoringPotensiLubangSurveiDetail as SurveiPotensiLubangDetail;

class Home extends Controller
{
    // public function index()
    // {
    //     $pembangunan_talikuat = DB::connection('talikuat')->table('data_umum')->where('is_deleted', '=', null);
        
    //     if (Auth::user()->internalRole->uptd) {
    //         if (Auth::user()->internalRole->uptd) {
    //             $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
    //             $pembangunan_talikuat = $pembangunan_talikuat->where('id_uptd', $uptd_id);
    //         }
    //     }
    //     $pembangunan_talikuat = $pembangunan_talikuat->get();

    //     $data_talikuat = DB::connection('talikuat')->select('SELECT
    //     ( SUM( master_laporan_harian.bobot )) as persentase,
    //     master_laporan_harian.id_data_umum,
    //     data_umum.nm_paket as nama_paket,
    //     data_umum.id_uptd
    // FROM
    //     `master_laporan_harian`
    //     JOIN jadual ON jadual.id = master_laporan_harian.id_jadual
    //     JOIN data_umum ON data_umum.id = master_laporan_harian.id_data_umum

    //     WHERE master_laporan_harian.ditolak = 4 AND data_umum.is_deleted IS NULL AND master_laporan_harian.reason_delete IS NULL
    // GROUP BY
    //     master_laporan_harian.id_data_umum');

    //     $detail_data_talikuat = null;
    //     foreach($pembangunan_talikuat as $data) {
    //         $detail_data_talikuat[$data->id] = $this->GetDataUmum($data->id);
    //     }
    //     // dd($detail_data_talikuat);


    //     // $lat = -6.76544300000000000;
    //     // $lon = 108.16815900000000000;
            
    //     // $nearby_awal = DB::table("master_ruas_jalan")
    //     //     ->select("*",DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
    //     //         * cos(radians(master_ruas_jalan.lat_awal)) 
    //     //         * cos(radians(master_ruas_jalan.long_awal) - radians(" . $lon . ")) 
    //     //         + sin(radians(" .$lat. ")) 
    //     //         * sin(radians(master_ruas_jalan.lat_awal))) AS distance"))
    //     //     ->groupBy("master_ruas_jalan.id")->orderBy("distance")
    //     //     ->take(10)->get();
    //     // $nearby_akhir = DB::table("master_ruas_jalan")
    //     //     ->select("*",DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
    //     //         * cos(radians(master_ruas_jalan.lat_akhir)) 
    //     //         * cos(radians(master_ruas_jalan.long_akhir) - radians(" . $lon . ")) 
    //     //         + sin(radians(" .$lat. ")) 
    //     //         * sin(radians(master_ruas_jalan.lat_akhir))) AS distance"))
    //     //     ->groupBy("master_ruas_jalan.id")->orderBy("distance")
    //     //     ->take(10)->get();
    //     // dd($nearby_akhir);
    //     // dd(count($temp_ruas));
        
    //     // // explode array lat long
    //     // $temp_ruas = RuasJalan::groupBy('id_ruas_jalan')->get();
    //     // foreach ($temp_ruas as $data =>$ruas) {
    //     //     echo " Id: ", $ruas->id_ruas_jalan,"<br>";
    //     //     if(isset($ruas->geo_prov->geo_json)){
    //     //         $dec =  json_decode( $ruas->geo_prov->geo_json );       
    //     //         for($i=0;$i<count($dec->coordinates[0]);$i++){
    //     //             echo "long: ", $dec->coordinates[0][$i][0];
    //     //             echo " lat: ", $dec->coordinates[0][$i][1],"<br>";
    //     //             $save=[
    //     //                 'id_ruas_jalan' =>$ruas->id_ruas_jalan,
    //     //                 'lat'=>$dec->coordinates[0][$i][1],
    //     //                 'long'=>$dec->coordinates[0][$i][0],
    //     //             ];
    //     //             DB::table('master_ruas_jalan_detail')->insert($save);
    //     //         }
    //     //     }     
    //     // }
    //     // dd($save);

    //     // $temp_ruas2 = RuasJalan::groupBy('id_ruas_jalan')->get();
    //     // foreach ($temp_ruas2 as $dat =>$ruas) {
    //     //     for($x=0; $x<2 ; $x++){
    //     //         echo $x;
    //     //         if($x==0){
    //     //             echo " lat_long_awal <br>";
    //     //             $save=[
    //     //                 'id_ruas_jalan' =>$ruas->id_ruas_jalan,
    //     //                 'lat'=>$ruas->lat_awal,
    //     //                 'long'=>$ruas->long_awal,
    //     //             ];
    //     //         }else{
    //     //             echo " lat_long_akhir <br>";
    //     //             $save=[
    //     //                 'id_ruas_jalan' =>$ruas->id_ruas_jalan,
    //     //                 'lat'=>$ruas->lat_akhir,
    //     //                 'long'=>$ruas->long_akhir,
    //     //             ];
    //     //         }
    //     //         DB::table('master_ruas_jalan_detail')->insert($save);
    //     //     }
    //     // }
    //     // dd($save);
    //     $temporari = UPTD::where('id','!=', 11);
    //     $temporari=$temporari->get();
    //     $data1 = [];
    //     $data2 = [];
    //     $data3 =[];
    //     $datauptd1 =[];
    //     $datauptd2 =[];
    //     $datakota =[];

    //     $datauptdkota =[];
    //     $datauptdkabupaten =[];

    //     foreach($temporari as $i){
    //         $merge = 'UPTD'.$i->id;
    //         array_push($datauptd1,$merge);
    //         array_push($data1,$merge);
    //         $temp2=[
    //             'value'=> $i->library_kota->count(),
    //             'groupId'=>$merge
    //         ];
    //         array_push($datauptd2,$temp2);
    //         $temp=[
    //             'value'=> $i->library_kota->count(),
    //             'name'=>$merge
    //         ];
    //         array_push($data2,$temp);

    //         $temp8=[
    //             'value'=> $i->kota->count(),
    //             'groupId'=>$merge
    //         ];
    //         array_push($datauptdkota,$temp8);
    //         $temp9=[
    //             'value'=> $i->kabupaten->count(),
    //             'groupId'=>$merge
    //         ];
    //         array_push($datauptdkabupaten,$temp9);
    //         $tempkota['dataGroupId']=$merge;
    //         $tempkota['data']=[];

    //         foreach($i->library_kota as $x){
    //             $temp3=[$x->name, $x->library_ruas->count()];
    //             array_push($tempkota['data'],$temp3);

    //             array_push($data1,$x->name);
    //             $temp1=[
    //                 'value'=> $x->library_ruas->count(),
    //                 'name'=>$x->name
    //             ];
    //             array_push($data3,$temp1);
    //         }
    //         array_push($datakota,$tempkota);
    //     }
    //     // dd($datauptdkabupaten);
    //     return view('admin.home', compact('pembangunan_talikuat', 'data_talikuat','detail_data_talikuat','data1','data2','data3','datauptd1','datauptd2','datakota','datauptdkota','datauptdkabupaten'));
    // }

    public function downloadFile()
    {
        $path = storage_path('app/public/Manual Book Teman Jabar DBMPR.pdf');
        return response()->download($path);
        // return response()->download($myFile, $newName, $headers);
    }

    public function GetDataUmum($id)
    {
        $tes = array();
        $jadual = DB::connection('talikuat')->table('jadual')->select('id', 'nmp')->where('id_data_umum', $id)->get();
        $data = DB::connection('talikuat')->table('data_umum')->where('id', $id)->get();
        foreach ($jadual as $e) {
            $dataJadual = DB::connection('talikuat')->table('detail_jadual')->where('id_jadual', $e->id)->orderBy('tgl', 'asc')->get();
            foreach ($dataJadual as $q) {
                $str = $q->nilai = str_replace(',', '.', $q->nilai);
                $q->nilai = floatval($str);
            }
            array_push($tes, $dataJadual);
        }
        $laporan = DB::connection('talikuat')->table('master_laporan_harian')->where([
            ['ditolak', 4],
            ['id_data_umum', $id],
            ['reason_delete', null]
        ])->get();
        return (object)[
            "curva" => $tes,
            "data_umum" => $data,
            "laporan" => [$laporan]
        ];
    }

    // public function index()
    // {
    //     $uptd1 = Dataumum::where('id_uptd', 1)->latest()->with('detail')->with('uptd')->get();
    //     $uptd2 = Dataumum::where('id_uptd', 2)->latest()->with('detail')->with('uptd')->get();
    //     $uptd3 = Dataumum::where('id_uptd', 3)->latest()->with('detail')->with('uptd')->get();
    //     $uptd4 = Dataumum::where('id_uptd', 4)->latest()->with('detail')->with('uptd')->get();
    //     $uptd5 = Dataumum::where('id_uptd', 5)->latest()->with('detail')->with('uptd')->get();
    //     $uptd6 = Dataumum::where('id_uptd', 6)->latest()->with('detail')->with('uptd')->get();

    //     return view('admin.home', compact('uptd1', 'uptd2', 'uptd3', 'uptd4', 'uptd5', 'uptd6'));
    // }

    public function index(Request $request)
    {   
        $uptd1 = DataUmum::where('id_uptd', 1)->with('laporanApproved')->get();
        $uptd2 = DataUmum::where('id_uptd', 2)->with('laporanApproved')->get();
        $uptd3 = DataUmum::where('id_uptd', 3)->with('laporanApproved')->get();
        $uptd4 = DataUmum::where('id_uptd', 4)->with('laporanApproved')->get();
        $uptd5 = DataUmum::where('id_uptd', 5)->with('laporanApproved')->get();
        $uptd6 = DataUmum::where('id_uptd', 6)->with('laporanApproved')->get();
        // if (Auth::user() && Auth::user()->internalRole->uptd && Auth::user()->sup_id) {
        //     $temp_user = User::where('sup_id',Auth::user()->sup_id)->with(['internalRole' => function ($query) {
        //         $query->where('role','LIKE','Kepala Satuan Unit Pemeliharaan %');
        //     }])->first(); 
        //     dd($temp_user->fcm_token);        
        // }
        $filter['tanggal_awal']= Carbon::now()->subDays(100)->format('Y-m-d');
        $filter['tanggal_akhir']= Carbon::now()->format('Y-m-d');
        if($request->tanggal_awal || $request->tanggal_akhir ){
            $filter['tanggal_awal']=  Carbon::createFromFormat('Y-m-d', $request->tanggal_awal)->format('Y-m-d');
            $filter['tanggal_akhir']=  Carbon::createFromFormat('Y-m-d', $request->tanggal_akhir)->format('Y-m-d');    
        }
        // $total_report = $this->count_pemeliharaan($filter['tanggal_awal'], $filter['tanggal_akhir']);
        $total_report=[
            'not_complete' => 0,
            'submit' => 0,
            'approve' => 0,
            'reject' => 0
        ];
        // dd($total_report);
        
        $pembangunan_talikuat = [];
        $data_talikuat = [];
        $detail_data_talikuat =[];
        
        $data_t_lubang = SurveiLubangDetail::whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ]);
        $data_t_lubang1 = SurveiLubangDetail::whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ]);
        $data_t_lubang2 = SurveiLubangDetail::whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ]);
        $data_t_lubang3 = SurveiPotensiLubangDetail::whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ]);

        $temporari['jumlah']['sisa'] = $data_t_lubang->whereNull('status')->get()->sum('jumlah');
        $temporari['jumlah']['perencanaan'] = $data_t_lubang1->where('status','Perencanaan')->get()->sum('jumlah');
        $temporari['jumlah']['penanganan'] = $data_t_lubang2->where('status','Selesai')->get()->sum('jumlah');
        $temporari1['jumlah']['potensi'] = $data_t_lubang3->get()->sum('jumlah');

        $temporari['panjang']['sisa'] =  round($data_t_lubang->whereNull('status')->get()->sum('panjang')/1000,3);
        $temporari['panjang']['perencanaan'] = round($data_t_lubang1->where('status','Perencanaan')->get()->sum('panjang')/1000,3);
        $temporari['panjang']['penanganan'] =round($data_t_lubang2->where('status','Selesai')->get()->sum('panjang')/1000,3);
        $temporari1['panjang']['potensi'] =round($data_t_lubang3->get()->sum('panjang')/1000,3);

        // dd($temporari);
        $uptd = UPTD::where('id','!=', 11);
        // if (Auth::user() && Auth::user()->internalRole->uptd) {
        //     $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
        //     $uptd=$uptd->where('id',$uptd_id);
        // }
        $uptd=$uptd->get();
        $data1 = [];
        $data2 = [];
        $data3 =[];
        $datauptd1 =[];
        $datauptd2 =[];
        $datakota =[];

        $datauptdkota =[];
        $datauptdkabupaten =[];

        $data_lubang_sisa =[];
        $data_lubang_perencanaan =[];
        $data_lubang_penanganan =[];
        $data_lubang_potensi =[];
        $data_lubang_total_km =[];

        foreach($uptd as $i){
            $merge = 'UPTD'.$i->id;
            array_push($datauptd1,$merge);
            array_push($data1,$merge);
            $temp2=[
                'value'=> $i->library_kota->count(),
                'groupId'=>$merge
            ];
            array_push($datauptd2,$temp2);
            $temp=[
                'value'=> $i->library_kota->count(),
                'name'=>$merge
            ];
            array_push($data2,$temp);

            $temp8=[
                'value'=> $i->kota->count(),
                'groupId'=>$merge
            ];
            array_push($datauptdkota,$temp8);
            $temp9=[
                'value'=> $i->kabupaten->count(),
                'groupId'=>$merge
            ];
            array_push($datauptdkabupaten,$temp9);
            $tempkota['dataGroupId']=$merge;
            $tempkota['data']=[];

            foreach($i->library_kota as $x){
                $temp3=[$x->name, $x->library_ruas->count()];
                array_push($tempkota['data'],$temp3);

                array_push($data1,$x->name);
                $temp1=[
                    'value'=> $x->library_ruas->count(),
                    'name'=>$x->name
                ];
                array_push($data3,$temp1);
            }
            array_push($datakota,$tempkota);


            $sisa=[
               
                'value'=>  round($i->lubang_sisa->whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])->sum('panjang')/1000,3),
                'groupId'=>$merge
            ];
            array_push($data_lubang_sisa,$sisa);
            $perencanaan=[
                'value'=> round($i->lubang_perencanaan->whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])->sum('panjang')/1000,3),
                'groupId'=>$merge
            ];
            array_push($data_lubang_perencanaan,$perencanaan);
            $penanganan=[
                'value'=> round($i->lubang_penanganan->whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])->sum('panjang')/1000,3),
                'groupId'=>$merge
            ];
            array_push($data_lubang_penanganan,$penanganan);
            $total=[
                'value'=> round($i->library_ruas->sum('panjang')/1000,3),
                'groupId'=>$merge
            ];
            array_push($data_lubang_total_km,$total);

            $potensi=[
                'value'=> round($i->lubang_potensi->whereBetween('tanggal',[$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])->sum('panjang')/1000,3),
                'groupId'=>$merge
            ];
            array_push($data_lubang_potensi,$potensi);

            $temporari_pemeliharaan = $this->count_pemeliharaan($filter['tanggal_awal'], $filter['tanggal_akhir'], $i->id);
            $chart_pemeliharaan['not_complete'][]= [
                'value'=> $temporari_pemeliharaan['not_complete'],
                'groupId'=>$merge
            ];
            $total_report['not_complete'] += $temporari_pemeliharaan['not_complete'];
            $chart_pemeliharaan['submit'][]= [
                'value'=> $temporari_pemeliharaan['submit'],
                'groupId'=>$merge
            ];
            $total_report['submit'] += $temporari_pemeliharaan['submit'];

            $chart_pemeliharaan['approve'][]= [
                'value'=> $temporari_pemeliharaan['approve'],
                'groupId'=>$merge
            ];
            $total_report['approve'] += $temporari_pemeliharaan['approve'];

            $chart_pemeliharaan['reject'][]= [
                'value'=> $temporari_pemeliharaan['reject'],
                'groupId'=>$merge
            ];
            $total_report['reject'] += $temporari_pemeliharaan['reject'];

        }
        // dd($total_report);
        $chart_lubang=[
            'potensi' => $data_lubang_potensi,
            'perencanaan'=> $data_lubang_perencanaan,
            'ditangani'=> $data_lubang_penanganan,
            'sisa'=> $data_lubang_sisa,
            'total_km'=> $data_lubang_total_km
        ];
        return view('admin.home', compact('pembangunan_talikuat', 'data_talikuat','detail_data_talikuat','data1','data2','data3','datauptd1','datauptd2','datakota','datauptdkota','datauptdkabupaten','filter','total_report', 'chart_pemeliharaan', 'chart_lubang', 'temporari', 'temporari1','uptd1','uptd2','uptd3','uptd4','uptd5','uptd6'));
    }
    public function count_pemeliharaan($tanggal_awal, $tanggal_akhir, $uptd = null )
    {
        $approve = 0;
        $reject = 0;
        $submit = 0;
        $not_complete = 0;
        
        $rekaps = DB::table('kemandoran')
        ->where('kemandoran.is_deleted',0)
        ->whereBetween('kemandoran.tglreal',[$tanggal_awal , $tanggal_akhir ])
        ->leftJoin('kemandoran_detail_status','kemandoran_detail_status.id_pek','=','kemandoran.id_pek')
        ->select('kemandoran.*','kemandoran_detail_status.status',DB::raw('max(kemandoran_detail_status.id ) as status_s'), DB::raw('max(kemandoran_detail_status.id ) as status_s'))
        ->groupBy('kemandoran.id_pek');
        // ->where('kemandoran_detail_status.status','Approved')
        if($uptd != null){
            $rekaps = $rekaps->where('kemandoran.uptd_id', $uptd);
        }
        $rekaps = $rekaps->get();
        // dd($rekaps);
        if($rekaps->count()>=1){
            foreach($rekaps as $it){
                // echo $it->status.' | '.$it->id_pek.'<br>';
                $it->status_material = DB::table('bahan_material')->where('id_pek', $it->id_pek)->exists();
                $rekaplap = DB::table('kemandoran_detail_status')->where('id', $it->status_s)->pluck('status')->first();
                $it->status = $rekaplap;
                if(($it->status == "Approved"||$it->status == "Rejected" ||$it->status == "Edited") || $it->status_material){
                    if($it->status == "Approved"){
                        $approve+=1;
                        // echo $it->status.' | '.$it->id_pek.'<br>';
                    }else if($it->status == "Rejected" ||$it->status == "Edited"){
                        $reject+=1;
                        // echo $it->status.' | '.$it->id_pek.'<br>';
                    }else
                        $submit+=1;
                }else
                    $not_complete+=1;
            }

        }
        return $temporari=[
            'not_complete' => $not_complete,
            'submit'=> $submit,
            'approve'=> $approve,
            'reject'=> $reject
        ];
    }
}