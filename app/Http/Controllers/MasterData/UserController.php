<?php

namespace App\Http\Controllers\MasterData;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // if(Auth::user()->internalRole->uptd){
        //     $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
        //     $laporan = $users->where('uptd_id',$uptd_id);
        // }

        $sup = DB::table('utils_sup');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $sup = $sup->where('uptd_id',$uptd_id);
        }
        $sup = $sup->get();

        $role = DB::table('user_role');
        $role = $role->where('is_active', '1');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $role = $role->where('uptd_id',$uptd_id);
        }
        $role = $role->get();

        return view('admin.master.user.index', compact('users', 'sup', 'role'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users',
        ]);

        if ($validator->fails()) {
            $color = "danger";
            $msg = "Email telah terdaftar";
            return back()->with(compact('color','msg'));
        }

        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['password'] = Hash::make($request->password);
        $user['role'] = "internal";
        $user['internal_role_id'] = $request->internal_role_id;
        $user['sup'] = $request->sup;

        $id = DB::table('users')->insertGetId($user);

        $userPegawai['no_pegawai'] = $request->no_pegawai;
        $userPegawai['nama'] = $request->name;
        $userPegawai['no_tlp'] = $request->no_tlp;
        $userPegawai['user_id'] = $id;
        $userPegawai['created_at'] = date('Y-m-d H:i:s');
        $userPegawai['created_by'] = Auth::user()->id;

        DB::table('user_pegawai')->insert($userPegawai);
        $color = "success";
        $msg = "Berhasil Menambah Data User";
        return back()->with(compact('color','msg'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        
        $sup = DB::table('utils_sup');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $sup = $sup->where('uptd_id',$uptd_id);
        }
        $sup = $sup->get();

        $role = DB::table('user_role');
        $role = $role->where('is_active', '1');
        if(Auth::user()->internalRole->uptd){
            $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
            $role = $role->where('uptd_id',$uptd_id);
        }
        $role = $role->get();

        return view('admin.master.user.edit', compact('user','sup','role'));
    }


    public function update(Request $request)
    {
        $userId = $request->id;
        $user['name'] = $request->name;
        $user['internal_role_id'] = $request->internal_role_id;
        $user['sup'] = $request->sup;
        $user['blokir'] = $request->blokir;

        if($request->password != ""){
            $user['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id',$userId)->update($user);

        $userPegawai['no_pegawai'] = $request->no_pegawai;
        $userPegawai['nama'] = $request->name;
        $userPegawai['no_tlp'] = $request->no_tlp;
        $userPegawai['user_id'] = $userId;
        $userPegawai['updated_at'] = date('Y-m-d H:i:s');
        $userPegawai['created_by'] = Auth::user()->id;

        DB::table('user_pegawai')->where('user_id',$userId)->update($userPegawai);

        $color = "success";
        $msg = "Berhasil Memperbaharui Data User";
        return back()->with(compact('color','msg'));
    }

    public function delete($id)
    {        
        $user = DB::table('users');
        $old = $user->where('id',$id);
        $old->delete();

        DB::table('user_pegawai')->where('user_id', $id)->update(array('is_delete'=>1));

        $color = "success";
        $msg = "Berhasil Menghapus Data User";
        return redirect(route('getMasterUser'))->with(compact('color','msg'));
    }

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

    public function detailUser($id){
        $users = DB::table('users')->where('id',$id)->get();
        return view('admin.master.user.manajemen.detail',[
                'users' => $users
            ]);
    }
    
    
    public function getDaftarRoleAkses(){
        
        $user_role = DB::table('user_role as a')
        ->select('role')
        ->get();
        $user_role_list = DB::table('user_role as a')
        ->distinct()
        ->select('a.role','a.id as role_id',DB::raw('GROUP_CONCAT(b.menu SEPARATOR ", ") as menu_user'))
        ->join('master_grant_role_aplikasi as b','a.id','=','b.internal_role_id')
        ->groupBy('a.role')
        ->orderBy('a.id')
        ->get();
        $internal = DB::table('master_grant_role_aplikasi as a')
        ->select('a.id','internal_role_id')
        ->groupBy('internal_role_id')
        ->get();
        foreach ($internal as $data) {
            $role_access = DB::table('utils_role_access as a')
            ->distinct()
            ->select('*',DB::raw('GROUP_CONCAT(a.role_access SEPARATOR ", ") as role_akses'))
            ->where('a.master_grant_role_aplikasi_id',$data->id)
            ->orderBy('a.master_grant_role_aplikasi_id')
            ->get();
            $role_akses[] = $role_access[0]->role_akses;
            $uptd_access = DB::table('utils_role_access_uptd as a')
            ->distinct()
            ->select(DB::raw('GROUP_CONCAT(a.uptd_name SEPARATOR ", ") as uptd_akses'))
            ->where('a.master_grant_role_aplikasi_id',$data->id)
            ->orderBy('a.master_grant_role_aplikasi_id')
            ->get();
            $uptd_akses[] = $uptd_access[0]->uptd_akses;
            
        }
        $menu = DB::table('master_grant_role_aplikasi as a')
        ->distinct()
        ->groupBy('a.menu')
        ->get();
        return view('admin.master.user.role_akses',
            [   
                'user_role' => $user_role,             
                'role_access' => $role_akses,
                'uptd_access' => $uptd_akses,
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
        $jml_menu = count($request->menu); 
        $id_role_access_list = DB::table('master_grant_role_aplikasi as a')
            ->select('a.id')
            ->orderBy('a.id','DESC')
            ->limit($jml_menu)
            ->get();
        for($i=0;$i<$jml_menu;$i++){
            
            
            for($j=0;$j<count($request->role_access);$j++){
                $role_access_list['role_access'] = $request->role_access[$j];
                $role_access_list['master_grant_role_aplikasi_id'] = $id_role_access_list[$i]->id;
                DB::table('utils_role_access')->insert($role_access_list); 
            }
            for($j=0;$j<count($request->uptd_access);$j++){
                $uptd_access_list['uptd_name'] = $request->uptd_access[$j];
                $uptd_access_list['master_grant_role_aplikasi_id'] = $id_role_access_list[$i]->id;
                DB::table('utils_role_access_uptd')->insert($uptd_access_list); 
            }
            
        }

        


        $color = "success";
        $msg = "Berhasil Menambah Data Grant Access Role Aplikasi";
        return back()->with(compact('color', 'msg'));
    }

    public function detailRoleAkses($id)
    { 
        $user_role_list = DB::table('user_role as a')
        ->distinct()
        ->select('a.role','a.id as role_id',DB::raw('GROUP_CONCAT(b.menu SEPARATOR ", ") as menu_user'))
        ->join('master_grant_role_aplikasi as b','a.id','=','b.internal_role_id')
        ->where('a.id',$id)
        ->groupBy('a.role')
        ->orderBy('a.id')
        ->get();
        $internal = DB::table('master_grant_role_aplikasi as a')
        ->select('a.id','internal_role_id')
        ->where('a.internal_role_id',$id)
        ->groupBy('internal_role_id')
        ->get();
        foreach ($internal as $data) {
            $role_access = DB::table('utils_role_access as a')
            ->distinct()
            ->select('*',DB::raw('GROUP_CONCAT(a.role_access SEPARATOR ", ") as role_akses'))
            ->where('a.master_grant_role_aplikasi_id',$data->id)
            ->orderBy('a.master_grant_role_aplikasi_id')
            ->get();
            $role_akses[] = $role_access[0]->role_akses;
            $uptd_access = DB::table('utils_role_access_uptd as a')
            ->distinct()
            ->select(DB::raw('GROUP_CONCAT(a.uptd_name SEPARATOR ", ") as uptd_akses'))
            ->where('a.master_grant_role_aplikasi_id',$data->id)
            ->orderBy('a.master_grant_role_aplikasi_id')
            ->get();
            $uptd_akses[] = $uptd_access[0]->uptd_akses;
            
        }
        return view('admin.master.user.detail_role_akses',
            [              
                'role_access' => $role_akses,
                'uptd_access' => $uptd_akses,
                'user_role_list' => $user_role_list
            ]);
    }
    public function deleteRoleAkses($id){
         
        $menu = DB::table('master_grant_role_aplikasi')
        ->where('internal_role_id',$id)
        ->get();
        
        

        for($i=0;$i<count($menu);$i++){
            $role_access = DB::table('utils_role_access')
            ->where('master_grant_role_aplikasi_id',$menu[$i]->id);

            $uptd_access = DB::table('utils_role_access_uptd')
            ->where('master_grant_role_aplikasi_id',$menu[$i]->id);
            $role_access->delete();
            $uptd_access->delete();
        }

        $role_akses = DB::table('master_grant_role_aplikasi')
        ->where('internal_role_id',$id);
        $role_akses->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Grant Access Role Aplikasi";
        return back()->with(compact('color', 'msg'));        
    }
    public function getDataRoleAkses($id){
        $user_role = DB::table('master_grant_role_aplikasi as a')
        ->distinct()
        ->join('user_role as b','b.id','=','a.internal_role_id')
        ->select('a.id','a.internal_role_id','a.menu','a.created_date','b.role')
        ->where('a.internal_role_id',$id)
        ->get();
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
        ->where('a.id',$id)
        ->get();
        return response()->json(["user_role" => $user_role,"role_access" => $role_access,"uptd_access" => $uptd_access,"user_role_list" => $user_role_list], 200);  
    }
    public function updateDataRoleAkses(Request $request){
        $menu = DB::table('master_grant_role_aplikasi')
        ->where('internal_role_id',$request->id)
        ->get();
        
        

        for($i=0;$i<count($menu);$i++){
            $role_access = DB::table('utils_role_access')
            ->where('master_grant_role_aplikasi_id',$menu[$i]->id);

            $uptd_access = DB::table('utils_role_access_uptd')
            ->where('master_grant_role_aplikasi_id',$menu[$i]->id);
            $role_access->delete();
            $uptd_access->delete();
        }

        $role_akses = DB::table('master_grant_role_aplikasi')
        ->where('internal_role_id',$request->id);
        $role_akses->delete();

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
        $jml_menu = count($request->menu); 
        $id_role_access_list = DB::table('master_grant_role_aplikasi as a')
            ->select('a.id')
            ->orderBy('a.id','DESC')
            ->limit($jml_menu)
            ->get();
        for($i=0;$i<$jml_menu;$i++){
            
            
            for($j=0;$j<count($request->role_access);$j++){
                $role_access_list['role_access'] = $request->role_access[$j];
                $role_access_list['master_grant_role_aplikasi_id'] = $id_role_access_list[$i]->id;
                DB::table('utils_role_access')->insert($role_access_list); 
            }
            for($j=0;$j<count($request->uptd_access);$j++){
                $uptd_access_list['uptd_name'] = $request->uptd_access[$j];
                $uptd_access_list['master_grant_role_aplikasi_id'] = $id_role_access_list[$i]->id;
                DB::table('utils_role_access_uptd')->insert($uptd_access_list); 
            }
            
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
