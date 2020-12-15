<?php

namespace App\Http\Controllers\MasterData;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUser()
    {
        $users = DB::table('users')->get();
        $roles = DB::table('user_role')->get();
        return view('admin.master.user.manajemen.index',[
                'users' => $users,
                'roles' => $roles
            ]);
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
    public function store(Request $request){
        $data['name'] = $request->nama;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->role;
        $data['internal_role_id'] = $request->internal_role_id;
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('users')->insert($data); 

        $color = "success";
        $msg = "Berhasil Menambah Data User";
        return back()->with(compact('color', 'msg'));
    }
    public function detailUser($id){
        $users = DB::table('users')->where('id',$id)->get();
        return view('admin.master.user.manajemen.detail',[
                'users' => $users
            ]);
    }
    public function edit($id){
        $users = DB::table('users')->where('id',$id)->get();
        return response()->json(["users" => $users], 200);
    }

    public function update(Request $request){
        $data['name'] = $request->nama;
        $data['email'] = $request->password;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->role;
        $data['internal_role_id'] = $request->internal_role_id;
        $data['updated_at'] = date('Y-m-d H:i:s');
        DB::table('users')->where('id',$request->id)->update($data); 

        $color = "success";
        $msg = "Berhasil Menambah Data User";
        return back()->with(compact('color', 'msg'));
    }
    public function delete($id){
        $users = DB::table('users')->delete('id',$id);
        
         $color = "success";
        $msg = "Berhasil Menghapus Data User";
        return back()->with(compact('color', 'msg'));
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
        $menu = DB::table('master_grant_role_aplikasi')
        ->distinct()
        ->select('id','internal_role_id','menu')
        ->get();
        return view('admin.master.user.role_akses',
            [
                'user_role' => $user_role,
                'role_access' => $role_access,
                'uptd_access' => $uptd_access,
                'user_role_list' => $user_role_list,
                'menu' => $menu
            ]);
    }
    public function createRoleAkses(Request $request)
    { 

        $id_role_access= DB::table('user_role as a')
        ->select('a.id','a.role')
        ->where('a.role',$request->user_role)
        ->get();
        for($i=0;$i<count($request->menu);$i++){
            $role_access['menu'] = $request->menu[$i];
            $role_access['internal_role_id']  = $id_role_access[0]->id;
            $role_access['created_date'] = date('Y-m-d H:i:s');
            DB::table('master_grant_role_aplikasi')->insert($role_access);
        } 

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
        $user_role = DB::table('user_role')->where('id',$id)->get();
        $user_role_name = $user_role[0]->role;
        $menu = DB::table('master_grant_role_aplikasi')->where('internal_role_id',$id)->get();
        $menu_id = $menu[0]->id;
        var_dump($menu_id);
        $role_access = DB::table('utils_role_access')->where("master_grant_role_aplikasi_id",$menu_id)->get();
        $uptd_access = DB::table('utils_role_access')->where("master_grant_role_aplikasi_id",$menu_id)->get();
        return view('admin.master.user.detail_role_akses',
            [
                'user_role_name' => $user_role_name,
                'menu' => $menu,
                'role_access' => $role_access,
                'uptd_access' => $uptd_access
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
        $user_role = DB::table('master_grant_role_aplikasi')
        ->where('id',$request->id)
        ->get();
        $id_user_role = $user_role[0]->id;

        $role_access = DB::table('utils_role_access')
        ->where('master_grant_role_aplikasi_id',$id_user_role);

        $uptd_access = DB::table('utils_role_access_uptd')
        ->where('master_grant_role_aplikasi_id',$id_user_role);

        $role_access->delete();
        $uptd_access->delete();

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
            $role_access_list['master_grant_role_aplikasi_id'] = $request->id;
            DB::table('utils_role_access')->insert($role_access_list); 
        }

        for($i=0;$i<count($request->uptd_access);$i++){
            $uptd_access_list['uptd_name'] = $request->uptd_access[$i];
            $uptd_access_list['master_grant_role_aplikasi_id'] = $request->id;
            DB::table('utils_role_access_uptd')->insert($uptd_access_list); 
        }

        $color = "success";
        $msg = "Berhasil Mengupdate Data Grant Access Role Aplikasi";
        return back()->with(compact('color', 'msg'));   
    }

    function getDataUserRole(){
        $user_role_list = DB::table('user_role')
        ->get();
        return view('admin.master.user.user_role.user_role',[
                'user_role_list' => $user_role_list
            ]);
    }

    public function createUserRole(Request $request){
        $create['role'] = $request->user_role;
        $create['is_superadmin'] = $request->super_admin;
        $create['parent'] = $request->parent;
        $create['keterangan'] = $request->keterangan;
        $create['is_active'] = $request->is_active;
        $create['is_deleted']= $request->is_deleted;
        $create['uptd'] = $request->uptd;
        $create['created_at'] = date('Y-m-d H:i:s');
        $create['created_by'] = Auth::user()->id;
        $create['parent_id'] = 0;
        DB::table('user_role')->insert($create);
        $color = "success";
        $msg = "Berhasil Menambah Data User Role";
        return back()->with(compact('color', 'msg'));
    }

    public function detailUserRole($id){
        $user_role= DB::table('user_role as a')
        ->where('id',$id)
        ->get();
        return view('admin.master.user.user_role.detail_user_role',[
                'user_role' => $user_role
            ]);
    }

    public function getUserRoleData($id){
        $user_role = DB::table('user_role')
        ->where('id',$id)
        ->get();
        return response()->json(["user_role" => $user_role], 200); 

    }
    public function updateUserRole(Request $request){
        $update['role'] = $request->user_role;
        $update['is_superadmin'] = $request->super_admin;
        $update['parent'] = $request->parent;
        $update['keterangan'] = $request->keterangan;
        $update['is_active'] = $request->is_active;
        $update['is_deleted']= $request->is_deleted;
        $update['uptd'] = $request->uptd;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $update['updated_by'] = Auth::user()->id;
        $update['parent_id'] = 0;
        DB::table('user_role')->where('id',$request->id)->update($update);
        $color = "success";
        $msg = "Berhasil Mengupdate Data User Role";
        return back()->with(compact('color', 'msg'));
    }
    public function deleteUserRole($id){
        $user_role = DB::table('user_role')
        ->where('id',$id)
        ->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data User Role";
        return back()->with(compact('color', 'msg')); 
    }
}
