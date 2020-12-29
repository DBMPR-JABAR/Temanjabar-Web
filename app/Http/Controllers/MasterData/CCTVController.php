<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CCTVController extends Controller
{
    public function index(){
    	$cctv = DB::table('cctv')->get();
    	return view('admin.master.CCTV.index',compact('cctv'));
    }

    public function create(Request $request){
    	$cctv['lokasi'] = $request->lokasi;
    	$cctv['lat'] = $request->lat;
    	$cctv['long'] = $request->long;
    	$cctv['url'] = $request->url;
    	$cctv['description'] = $request->description;
    	$cctv['category'] = $request->category;
    	$cctv['status'] = $request->status;
        $cctv['enable_vehicle_counting'] = $request->enable_vehicle_counting;
    	DB::table('cctv')->insert($cctv);
    	$color = "success";
        $msg = "Berhasil Menambah Data CCTV";
        return back()->with(compact('color', 'msg'));
    }

    public function edit($id){
        $cctv = DB::table('cctv')
        ->where('id',$id)
        ->get();
        return response()->json(["cctv" => $cctv], 200); 

    }
    public function detail($id){
    	$cctv = DB::table('cctv')->where('ID',$id)->get();
    	return view('admin.master.CCTV.detail',compact('cctv'));
    }

    public function update(Request $request){
    	$cctv['lokasi'] = $request->lokasi;
    	$cctv['lat'] = $request->lat;
    	$cctv['long'] = $request->long;
    	$cctv['url'] = $request->url;
    	$cctv['description'] = $request->description;
    	$cctv['category'] = $request->category;
    	$cctv['status'] = $request->status;
        $cctv['enable_vehicle_counting'] = $request->enable_vehicle_counting;
    	DB::table('cctv')->where('ID',$request->id)->update($cctv);
    	$color = "success";
        $msg = "Berhasil Mengupdate Data CCTV";
        return back()->with(compact('color', 'msg'));
    }

    public function delete($id){
        $user_role = DB::table('cctv')
        ->where('id',$id)
        ->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data CCTV";
        return back()->with(compact('color', 'msg')); 
    }
}
