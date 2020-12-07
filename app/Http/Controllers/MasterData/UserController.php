<?php

namespace App\Http\Controllers\MasterData;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser()
    {
        return view('admin.master.user.index');
    }

    public function getUserAPI()
    {
        $response = [
            'status' => 'false',
            'data' => []
        ];
        $users = DB::table('users');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $laporan = $users->where('uptd_id',$uptd_id);
        }
        $laporan = $laporan->get();
        $response['data'] = $laporan;
        return response()->json($response, 200);
    }
    public function getDaftarRoleAkses(){
        $user_role = DB::table('master_grant_role_aplikasi as a')
        ->distinct()
        ->join('user_role as b','b.id','=','a.internal_role_id')
        ->select('a.id as user_role_id','a.internal_role_id','a.menu','a.created_date','b.role')
        ->get();
        $role_access = DB::table('utils_role_access as a')
        ->distinct()
        ->select('a.id','a.role_access','a.master_grant_role_aplikasi_id')
        ->get();
        $uptd_access = DB::table('utils_role_access_uptd as a')
        ->distinct()
        ->select('a.id','a.uptd_name','a.master_grant_role_aplikasi_id')
        ->get();
        $user_role_list = DB::table('user_role as a')
        ->distinct()
        ->select('a.role','a.id as role_id')
        ->get();
        return view('admin.master.user.role_akses',
            [
                'user_role' => $user_role,
                'role_access' => $role_access,
                'uptd_access' => $uptd_access,
                'user_role_list' => $user_role_list
            ]);
    }
    public function createRoleAkses(Request $request)
    { 

        $id_role_access= DB::table('user_role as a')
        ->select('a.id','a.role')
        ->where('a.role',$request->user_role)
        ->get();
        $role_access['menu'] = $request->menu;
        $role_access['internal_role_id']  = $id_role_access[0]->id;
        $role_access['created_date'] = date('Y-m-d H:i:s');
        DB::table('master_grant_role_aplikasi')->insert($role_access); 

        for($i=0;$i<count($request->role_access);$i++){
            $role_access_list['role_access'] = $request->role_access[$i];
            $id_role_access_list = DB::table('master_grant_role_aplikasi as a')
            ->select('a.id')
            ->orderBy('a.id','DESC')
            ->limit(1)
            ->get();
            $role_access_list['master_grant_role_aplikasi_id'] = $id_role_access_list[0]->id;
            DB::table('utils_role_access')->insert($role_access_list); 
        }

        for($i=0;$i<count($request->uptd_access);$i++){
            $uptd_access_list['uptd_name'] = $request->uptd_access[$i];
            $id_uptd_access = DB::table('master_grant_role_aplikasi as a')
            ->select('a.id')
            ->orderBy('a.id','DESC')
            ->limit(1)
            ->get();
            $uptd_access_list['master_grant_role_aplikasi_id'] = $id_uptd_access[0]->id;
            DB::table('utils_role_access_uptd')->insert($uptd_access_list); 
        }


        $color = "success";
        $msg = "Berhasil Menambah Data Grant Access Role Aplikasi";
        return back()->with(compact('color', 'msg'));
    }

    public function detailRoleAkses($id)
    { 
        $user_role = DB::table('master_grant_role_aplikasi as a')
        ->distinct()
        ->join('user_role as b','b.id','=','a.internal_role_id')
        ->select('a.id','a.internal_role_id','a.menu','a.created_date','b.role')
        ->where('a.id',$id)
        ->get();
        $id_user_role = $user_role[0]->internal_role_id;
        $role_access = DB::table('utils_role_access as a')
        ->distinct()
        ->select('a.id','a.role_access','a.master_grant_role_aplikasi_id')
        ->where('a.master_grant_role_aplikasi_id',$id)
        ->get();
        $uptd_access = DB::table('utils_role_access_uptd as a')
        ->distinct()
        ->select('a.id','a.uptd_name','a.master_grant_role_aplikasi_id')
        ->where('a.master_grant_role_aplikasi_id',$id)
        ->get();
        $user_role_list = DB::table('user_role as a')
        ->distinct()
        ->select('a.role','a.id as role_id')
        ->where('a.id',$id_user_role)
        ->get();
        return view('admin.master.user.detail_role_akses',
            [
                'user_role' => $user_role,
                'role_access' => $role_access,
                'uptd_access' => $uptd_access,
                'user_role_list' => $user_role_list
            ]);
    }
    public function deleteRoleAkses($id){
         
        $user_role = DB::table('master_grant_role_aplikasi')
        ->where('id',$id)
        ->get();
        $id_user_role = $user_role[0]->id;
        $data_user_role = $user_role = DB::table('master_grant_role_aplikasi')
        ->where('id',$id); 

        $role_access = DB::table('utils_role_access')
        ->where('master_grant_role_aplikasi_id',$id_user_role);

        $uptd_access = DB::table('utils_role_access_uptd')
        ->where('master_grant_role_aplikasi_id',$id_user_role);

        $data_user_role->delete();
        $role_access->delete();
        $uptd_access->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Grant Access Role Aplikasi";
        return back()->with(compact('color', 'msg'));        
    }
    public function getDataRoleAkses($id){
        $user_role = DB::table('master_grant_role_aplikasi as a')
        ->distinct()
        ->join('user_role as b','b.id','=','a.internal_role_id')
        ->select('a.id','a.internal_role_id','a.menu','a.created_date','b.role')
        ->where('a.id',$id)
        ->get();
        $id_user_role = $user_role[0]->internal_role_id;
        $role_access = DB::table('utils_role_access as a')
        ->distinct()
        ->select('a.id','a.role_access','a.master_grant_role_aplikasi_id')
        ->where('a.master_grant_role_aplikasi_id',$id)
        ->get();
        $uptd_access = DB::table('utils_role_access_uptd as a')
        ->distinct()
        ->select('a.id','a.uptd_name','a.master_grant_role_aplikasi_id')
        ->where('a.master_grant_role_aplikasi_id',$id)
        ->get();
        $user_role_list = DB::table('user_role as a')
        ->distinct()
        ->select('a.role','a.id as role_id')
        ->where('a.id',$id_user_role)
        ->get();
        return response()->json(["user_role" => $user_role,"role_access" => $role_access,"uptd_access" => $uptd_access,"user_role_list" => $user_role_list], 200);  
    }
    public function updateDataRoleAkses(Request $request){
        $internal_role_id = DB::table('user_role as a')
        ->select('a.id','a.role')
        ->where('a.role',$request->user_role)
        ->get();
        $internal_role_id = $internal_role_id[0]->id;
        $data['internal_role_id'] = $internal_role_id;
        $data['menu'] = $request->menu;
        DB::table('master_grant_role_aplikasi')->where('id',$request->id)->update($data);
        for($i=0;$i<count($request->role_access);$i++){
            $role_access_list['role_access'] = $request->role_access[$i];
            DB::table('utils_role_access')->where('master_grant_role_aplikasi_id',$request->id)->update($role_access_list); 
        }

        for($i=0;$i<count($request->uptd_access);$i++){
            $uptd_access_list['uptd_name'] = $request->uptd_access[$i];
            DB::table('utils_role_access_uptd')->where('master_grant_role_aplikasi_id',$request->id)->update($uptd_access_list);
        }
        $color = "success";
        $msg = "Berhasil Mengupdate Data Grant Access Role Aplikasi";
        return back()->with(compact('color', 'msg'));   
    }
}
