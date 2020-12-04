<?php

namespace App\Http\Controllers\MasterData;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
}
