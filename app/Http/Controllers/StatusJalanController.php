<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StatusJalanController extends Controller
{

    public function index()
    {
        return view('landing.status_jalan.index');
    }

    public function api_index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['data']['error'] = $validator->errors();
            return response()->json($this->response, 200);
        }

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = $request->radius;
        $pemeliharaan = DB::table('kemandoran')
            ->select('kemandoran.*')
            ->selectRaw('( 6371393 * acos( cos( radians(?) ) *
                           cos( radians( lat ) )
                           * cos( radians( lng ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( lat ) ) )
                         ) AS distance', [$latitude, $longitude, $latitude])
            ->havingRaw("distance < ?", [$radius])
            ->orderBy('distance')
            ->get();
        $response['pemeliharaan'] = $pemeliharaan;
        $response['test'] = $radius.$latitude.$longitude;
        return response()->json($response, 200);
    }
}
