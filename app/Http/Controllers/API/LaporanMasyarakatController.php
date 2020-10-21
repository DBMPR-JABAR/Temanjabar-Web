<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transactional\LaporanMasyarakat;
use App\Http\Resources\GeneralResource;
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
    public function index()
    {
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
                $laporanMasyarakat['gambar'] = $path;
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
