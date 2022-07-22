<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Transactional\UPTD;
use Illuminate\Support\Facades\Auth;

class UtilsController extends Controller
{
    public function getUPTD()
    {
        try {
            $uptd_list = UPTD::get();
            $this->response['status'] = 'success';
            $this->response['data'] = $uptd_list;
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    public function getUPTDByUser()
    {
        try {
            $uptd_list = DB::table('landing_uptd');
            if (Auth::user() && Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $uptd_list= $uptd_list->where('id',$uptd_id);
            }
            $uptd_list= $uptd_list->get();

            $this->response['status'] = 'success';
            $this->response['data'] = $uptd_list;
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }

    public function getSUP()
    {
        try {
            $sup = DB::table('utils_sup')->get();
            $this->response['status'] = 'success';
            $this->response['data'] = $sup;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    public function getSUPByUser()
    {
        try {
            $sup = DB::table('utils_sup');

            if (Auth::user() && Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                if (Auth::user()->sup_id) {
                    $sup = $sup->where('id', Auth::user()->sup_id);
                }else{
                    $sup = $sup->where('uptd_id', $uptd_id);
                }
            }
            $sup = $sup->get();
            $this->response['status'] = 'success';
            $this->response['data'] = $sup;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    public function getJenisLaporan()
    {
        try {
            $jenis_laporan = DB::table('utils_jenis_laporan')->get();
            $this->response['status'] = 'success';
            $this->response['data'] = $jenis_laporan;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    public function getKegiatanPekerjaan()
    {
        try {
            $kegiatan_pekerjaan = DB::table('utils_nama_kegiatan_pekerjaan')->get();
            $this->response['status'] = 'success';
            $this->response['data'] = $kegiatan_pekerjaan;

            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['message'] = 'Internal Error';
            $this->response['error']['message'] = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
    
    public function has_access($permission)
    {
        $permission = (object)[
            'create' => hasAccess(auth('api')->user()->internal_role_id, $permission, "Create"),
            'view' => hasAccess(auth('api')->user()->internal_role_id, $permission, "View"),
            'update' => hasAccess(auth('api')->user()->internal_role_id, $permission, "Update"),
            'delete' => hasAccess(auth('api')->user()->internal_role_id, $permission, "Delete"),
        ];
        $this->response['status'] = 'success';
        $this->response['data']['permission'] = $permission;
        return response()->json($this->response, 200);
    }

    public function mapsLebaran2022()
    {
        return view('maps');
    }
}
