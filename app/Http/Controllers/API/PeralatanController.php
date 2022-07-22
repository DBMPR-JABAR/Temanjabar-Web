<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ItemPeralatan;

class PeralatanController extends Controller
{
    //
    public function getData()
    {
        try {
            $data = ItemPeralatan::get();

            $this->response['status'] = 'success';
            $this->response['data']['jenis_pekerjaan'] = $data;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
}
