<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GeneralResource;
use App\Model\DWH\VehicleCounting;

class VehicleCountingController extends Controller
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
        return (new GeneralResource(VehicleCounting::all()));
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
            $vehicleCounting = new VehicleCounting;
            $vehicleCounting->fill($request->except(['GAMBAR']));
            if($request->GAMBAR != null){
                $path = 'vehicle_counting/'.date("YmdHis").'_'.$request->GAMBAR->getClientOriginalName();
                $request->GAMBAR->storeAs('public/',$path);
                $vehicleCounting['GAMBAR'] = url('storage/'.$path);
            }
            $vehicleCounting->save();
            $this->response['status'] = 'success';
            $this->response['data']['ID'] = $vehicleCounting->id;
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
