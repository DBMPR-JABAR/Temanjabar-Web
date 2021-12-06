<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Transactional\SurveiKerusakan;
use App\Model\Transactional\Survei;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveiController extends Controller
{
    private $response;
    public function __construct() {
        $this->response = [
            'status' => 'false',
        ];
    }

    public function insertKerusakan(Request $request)
    {

        try {
            $code = 200;
            if($request->hasFile('gambar')){
                foreach ($request->file('gambar') as $file) {
                    $path = 'survei/kerusakan/'.$file->getClientOriginalName();
                    $file->storeAs('public/', $path);
                }
            }

            $json = json_decode($request->data, true);

            foreach ($json['data'] as $data) {
                $kerusakan = SurveiKerusakan::updateOrCreate(['id' => $data['id']], $data);
            }


            $this->response['status'] = 'success';
            $this->response['message'] = 'Berhasil Sinkronisasi Kerusakan';
        } catch (\Exception $e) {
            $code = 500;

            $this->response['status'] = 'Internal Error';
            $this->response['message'] = $e->getMessage();
        }

        return response()->json($this->response, $code);

    }

    public function insertKemantapan(Request $request)
    {

        try {
            $code = 200;
            $survei = Survei::updateOrCreate(
                ['idruas' => $request->idruas, 'tgl_survei' => $request->tgl_survei],
                $request->all()
            );

            $this->response['status'] = 'success';
            $this->response['message'] = 'Berhasil Sinkronisasi Kemantapan Jalan';
        } catch (\Exception $e) {
            $code = 500;

            $this->response['status'] = 'Internal Error';
            $this->response['message'] = $e->getMessage();
        }

        return response()->json($this->response, $code);

    }

    public function getUsers()
    {

        // return [
        //     $user->email => [
        //         "password" => $user->password,
        //         "name" => $user->name,
        //         "uptd" => $user->internalRole->uptd ?? "*"
        //     ]
        // ];

        $users = User::where("role","internal")->get();
        $mappedUsers = [];

        foreach ($users as $user) {
            $uptd = $user->internalRole->uptd ?? "*";

            $mappedUsers[$user->email] = [
                "password" => $user->password,
                "name" => $user->name,
                "uptd" => Str::replaceFirst('uptd', 'UPTD ', $uptd)
            ];
        }

        return response()->json($mappedUsers, 200);
    }
}
