<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class DetailUserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        if($id != Auth::user()->id){
            $color = "danger";
            $msg = "Somethink when wrong!";
            return back()->with(compact('color', 'msg'));
            // return redirect('admin/user/profile/'. auth()->user()->id)->with(['error' => 'Somethink when wrong!']);
        }else{
            $profile = DB::table('user_pegawai')->where('user_id',$id)->first();
            if($profile){
                $kota = $profile->city_id ? DB::table('indonesia_cities')->where('id', $profile->city_id)->pluck('name')->first() :'';
                $provinsi = $profile->province_id? DB::table('indonesia_provinces')->where('id', $profile->province_id)->pluck('name')->first()  :'';
                $profile->provinsi=$provinsi;
                $profile->kota=$kota;
            }
            
            return view('admin.master.user.show',compact('profile'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id != Auth::user()->id){
            $color = "danger";
            $msg = "Somethink when wrong!";
            return back()->with(compact('color', 'msg'));
            // return redirect('admin/user/profile/'. auth()->user()->id)->with(['error' => 'Somethink when wrong!']);
        }else{
            $profile = DB::table('user_pegawai')->where('user_id',$id)->first();
            $cities ="";
            $provinces ="";
            $provinces =  DB::table('indonesia_provinces')->pluck('name', 'id');
            if($profile){
                // dd($profile);
                if($profile->city_id != null){
                    $cities =  DB::table('indonesia_cities')->where('province_id', $profile->province_id)->pluck('name', 'id');
                }
            }
            // dd($cities);
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
                // $uptd_id = str_replace('uptd','',Auth::user()->internalRole->uptd);
                $role = $role->where('uptd',Auth::user()->internalRole->uptd);
            }
            $role = $role->get();
            // dd($role);

            return view('admin.master.user.edit_detail_user',compact('profile','user','sup','role','provinces','cities'));
        }
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
        if($id != Auth::user()->id){
            $color = "danger";
            $msg = "Somethink when wrong!";
            return back()->with(compact('color', 'msg'));
            // return redirect('admin/user/profile/'. auth()->user()->id)->with(['error' => 'Somethink when wrong!']);
        }else{
            
            // dd($request);
            $this->validate($request,[
                'nama' => 'required',
                'no_pegawai'   => 'required',
                'tgl_lahir'    => 'required',
                'tmp_lahir'    => 'required',
                'jenis_kelamin'    => 'required',
                'no_tlp'    => 'numeric|digits_between:8,13',
                'no_tlp_rumah'    => '',  
                'sup_id' => '',
                'tgl_mulai_kerja' => '',
                'sekolah' => '',
                'jejang' => '',
                'jurusan_pendidikan' => '',
                'provinsi' => '',
                'kota' => '',
                'kode_pos' => '',
                'alamat' => '',
                'agama' => 'required',
                ]);
            $temp = explode(",",$request->input('sup_id'));
            
            $userprofile['nama'] = $request->input('nama');
                // $userprofile['frontDegree']     = $request->input('frontDegree'); 
                // $userprofile['backDegree']     = $request->input('backDegree'); 
            $userprofile['no_pegawai']     = $request->input('no_pegawai');
            $userprofile['tgl_lahir']   = $request->input('tgl_lahir');  
            $userprofile['tmp_lahir']   = $request->input('tmp_lahir');  
            $userprofile['agama']  = $request->input('agama');  

            $userprofile['jenis_kelamin'] = $request->input('jenis_kelamin');
            // dd($userprofile['jenis_kelamin']);
            $userprofile['no_tlp']  = $request->input('no_tlp');  
            $userprofile['no_tlp_rumah']  = $request->input('no_tlp_rumah');  
            $userprofile['tgl_mulai_kerja']  = $request->input('tgl_mulai_kerja');  
            $userprofile['sekolah']  = $request->input('sekolah');  
            $userprofile['jejang']  = $request->input('jejang');  
            $userprofile['jurusan_pendidikan']  = $request->input('jurusan_pendidikan');  
            $userprofile['province_id']  = $request->input('provinsi');  
            $userprofile['city_id']  = $request->input('kota');  
            $userprofile['kode_pos']  = $request->input('kode_pos');  
            $userprofile['alamat']  = $request->input('alamat');   
            if($request->input('sup_id') != null){
                $userupdat['sup_id']= $temp[0]; 
                $userupdat['sup']= $temp[1]; 
                // dd($temp[0]);
                $updatetouser = DB::table('users')->where('id', $id)->update($userupdat);
            }
            $updateprofile = DB::table('user_pegawai')
            ->where('user_id', $id)->updateOrInsert($userprofile);
            if($updateprofile){
                //redirect dengan pesan sukses
                $color = "success";
                $msg = "Data Berhasil Diupdate!";
                return redirect(route('editProfile', $id))->with(compact('color','msg'));
            }else{
                //redirect dengan pesan error
                $color = "danger";
                $msg = "Data Gagal Diupdate!";
                return redirect(route('editProfile', $id))->with(compact('color', 'msg'));
               
            }
        }
    }

    public function updateaccount(Request $request, $id)
    {
        //
        if($id != Auth::user()->id){
            $color = "danger";
            $msg = "Somethink when wrong!";
            return back()->with(compact('color', 'msg'));
            // return redirect('admin/user/profile/'. auth()->user()->id)->with(['error' => 'Somethink when wrong!']);
        }else{
            $datai=["email" => Auth::user()->email,
                    "password" => $request->input('password_lama')];
            $exist = Auth::attempt($datai);
            // dd(bcrypt($request->input('password_lama')));

            // echo Auth::user()->password;
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password'   => 'confirmed'
            ]);
            if ($validator->fails()) {
                $color = "danger";
                $msg = $validator->messages()->first();
                return redirect(route('editProfile', $id))->with(compact('color', 'msg'));
            }
            
            // $this->validate($request,[
            //     'email' => 'required|email',
            //     'password'   => 'confirmed'
            // ]);
            if($request->input('password') != ""){
                if($exist){
                    $useraccount['password']     = bcrypt($request->input('password'));
                }else{
                    $color = "danger";
                    $msg ="Password Lama Salah ";
                    return redirect(route('editProfile', $id))->with(compact('color', 'msg'));
                }
            }
            $useraccount['email'] = $request->input('email');
            // dd($useraccount['password']);
            $updateaccount = DB::table('users')
            ->where('id', $id)->update($useraccount);
            if($updateaccount){
                //redirect dengan pesan sukses
                $color = "success";
                $msg = "Akun Berhasil Diupdate!";
                return redirect(route('editProfile', $id))->with(compact('color','msg'));
            }else{
                //redirect dengan pesan error
                $color = "danger";
                $msg = "Akun Gagal Diupdate!";
                return redirect(route('editProfile', $id))->with(compact('color', 'msg'));
            }
        }
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
