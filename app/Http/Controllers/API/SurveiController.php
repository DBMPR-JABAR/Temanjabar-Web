<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SurveiController extends Controller
{
    private $response;
    public function __construct() {
        $this->response = [
            'status' => 'false',
            'data' => []
        ];
    }

    public function insertKerusakan(Request $request)
    {
        if($request->hasFile('gambar')){
            foreach ($request->file('gambar') as $file) {
                $path = 'survei/kerusakan/'.$file->getClientOriginalName();
                $file->storeAs('public/', $path);
            }
        }

        $json = json_decode($request->data);
        print_r($json->data[0]->nama);
        // foreach ($json->data as $data) {
        //     print_r($data->kelas." - ".$data->nama);
        // }

        $this->response['status'] = 'success';
        // $this->response['data'] = $data;

    }
}
