<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            // dd($profile);
            return view('admin.master.user.show',compact('profile'));
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

            $this->validate($request,[
                'nama' => '',
                // 'frontDegree'    => '',
                // 'backDegree'    => '',
                'no_pegawai'   => '',
                'tgl_lahir'    => '',
                'jenis_kelamin'    => '',
                'no_tlp'    => '',   
            ]);
            // dd($request);
            $userprofile['nama'] = $request->input('nama');
            // $userprofile['frontDegree']     = $request->input('frontDegree'); 
            // $userprofile['backDegree']     = $request->input('backDegree'); 
            $userprofile['no_pegawai']     = $request->input('no_pegawai');
            $userprofile['tgl_lahir']   = $request->input('tgl_lahir');  
            $userprofile['jenis_kelamin'] = $request->input('jenis_kelamin');
            // dd($userprofile['jenis_kelamin']);
            $userprofile['no_tlp']  = $request->input('no_tlp');  

            $updateprofile = DB::table('user_pegawai')
            ->where('user_id', $id)->update($userprofile);
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
