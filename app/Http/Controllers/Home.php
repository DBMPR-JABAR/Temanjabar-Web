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
use App\talikuat\Dataumum;

class Home extends Controller
{
    // public function index()
    // {
    // //     $pembangunan_talikuat = DB::connection('talikuat')->table('data_umum')->where('is_deleted', '=', null);


        
    // //     if (Auth::user()->internalRole->uptd) {
    // //         if (Auth::user()->internalRole->uptd) {
    // //             $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
    // //             $pembangunan_talikuat = $pembangunan_talikuat->where('id_uptd', $uptd_id);
    // //         }
    // //     }
    // //     $pembangunan_talikuat = $pembangunan_talikuat->get();

    // //     $data_talikuat = DB::connection('talikuat')->select('SELECT
    // //     ( SUM( master_laporan_harian.bobot )) as persentase,
    // //     master_laporan_harian.id_data_umum,
    // //     data_umum.nm_paket as nama_paket,
    // //     data_umum.id_uptd
    // // FROM
    // //     `master_laporan_harian`
    // //     JOIN jadual ON jadual.id = master_laporan_harian.id_jadual
    // //     JOIN data_umum ON data_umum.id = master_laporan_harian.id_data_umum

    // //     WHERE master_laporan_harian.ditolak = 4 AND data_umum.is_deleted IS NULL AND master_laporan_harian.reason_delete IS NULL
    // // GROUP BY
    // //     master_laporan_harian.id_data_umum');

    // //     $detail_data_talikuat = null;
    // //     foreach($pembangunan_talikuat as $data) {
    // //         $detail_data_talikuat[$data->id] = $this->GetDataUmum($data->id);
    // //     }
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

    public function index()
    {
        $uptd1 = Dataumum::where('id_uptd', 1)->latest()->with('detail')->with('uptd')->get();
        $uptd2 = Dataumum::where('id_uptd', 2)->latest()->with('detail')->with('uptd')->get();
        $uptd3 = Dataumum::where('id_uptd', 3)->latest()->with('detail')->with('uptd')->get();
        $uptd4 = Dataumum::where('id_uptd', 4)->latest()->with('detail')->with('uptd')->get();
        $uptd5 = Dataumum::where('id_uptd', 5)->latest()->with('detail')->with('uptd')->get();
        $uptd6 = Dataumum::where('id_uptd', 6)->latest()->with('detail')->with('uptd')->get();

        return view('admin.home', compact('uptd1', 'uptd2', 'uptd3', 'uptd4', 'uptd5', 'uptd6'));
    }
}
