<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailKemantapanJalanResource;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\KemantapanJalanResource;
use App\Http\Resources\RekapKemantapanJalanResource;
use App\Model\DWH\KemantapanJalan;
use App\Model\DWH\RuasJalanDWH;
use App\Model\Transactional\RuasJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuasJalanController extends Controller
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
    public function index()
    {
        return (new GeneralResource(RuasJalanDWH::all()));
    }
    public function getRuas()
    {
        try {
            $ruas = RuasJalan::select('id_ruas_jalan','nama_ruas_jalan')->get();
            $this->response['status'] = 'success';
            $this->response['data'] = $ruas;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    public function getRuasByUser()
    {
        try {

            if(Auth::user()->ruas()->exists()){
                $ruas = Auth::user()->ruas()->select('id_ruas_jalan','nama_ruas_jalan')->get();
            }else{
                if (Auth::user() && Auth::user()->internalRole->uptd) {
                    $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                    if (Auth::user()->sup_id) {
                        $ruas = RuasJalan::select('id_ruas_jalan','nama_ruas_jalan')->where('kd_sppjj',Auth::user()->data_sup->kd_sup)->get();
                    } else {
                        $ruas = RuasJalan::select('id_ruas_jalan','nama_ruas_jalan')->where('uptd_id',$uptd_id)->get();
                    }
                }else{
                    $ruas = RuasJalan::select('id_ruas_jalan','nama_ruas_jalan')->get();
                }
            }
            $this->response['status'] = 'success';
            $this->response['data'] = $ruas;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    public function getKemantapanJalan()
    {
        return (KemantapanJalanResource::collection(KemantapanJalan::all())->additional(['status' => 'success']));
    }

    public function getDetailKemantapanJalan($id)
    {
        return new DetailKemantapanJalanResource(KemantapanJalan::findOrFail($id));
    }

    public function getRekapKemantapanJalan()
    {
        try {
            $luas = KemantapanJalan::sum('LUAS');
            $kondisi['SANGAT_BAIK'] = KemantapanJalan::sum('SANGAT_BAIK');
            $kondisi['BAIK'] = KemantapanJalan::sum('BAIK');
            $kondisi['SEDANG'] = KemantapanJalan::sum('SEDANG');
            $kondisi['JELEK'] = KemantapanJalan::sum('JELEK');
            $kondisi['PARAH'] = KemantapanJalan::sum('PARAH');
            $kondisi['SANGAT_PARAH'] = KemantapanJalan::sum('SANGAT_PARAH');
            $kondisi['HANCUR'] = KemantapanJalan::sum('HANCUR');

            $this->response['status'] = 'success';
            $this->response['data'] =  [
                "luas_jalan" => $luas,
                "kondisi_jalan" => [
                    [
                       "domain"=> "Hancur",
                        "measure"=> $kondisi['HANCUR']
                    ],
                    [
                        "domain"=> "Sangat Parah",
                        "measure"=> $kondisi['SANGAT_PARAH']
                    ],
                    [
                        "domain"=> "Parah",
                        "measure"=> $kondisi['PARAH']
                    ],
                    [
                        "domain"=> "Jelek",
                        "measure"=> $kondisi['JELEK']
                    ],
                    [
                        "domain"=> "Sedang",
                        "measure"=> $kondisi['SEDANG']
                    ],
                    [
                        "domain"=> "Baik",
                        "measure"=> $kondisi['BAIK']
                    ],
                    [
                        "domain"=> "Sangat Baik",
                        "measure"=> $kondisi['SANGAT_BAIK']
                    ]
                ]
            ];

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }

        // return new RekapKemantapanJalanResource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
