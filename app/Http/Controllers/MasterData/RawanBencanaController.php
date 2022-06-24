<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;
use App\Model\Transactional\RuasJalan;
use App\Model\Transactional\RawanBencana as Rawan;
use Carbon\Carbon;

class RawanBencanaController extends Controller
{
    public function __construct()
    {
        $roles = setAccessBuilder('Rawan Bencana', ['createData'], ['index','getData','getDataSUP','getURL','json'], ['editData','updateData'], ['deleteData']);
        foreach ($roles as $role => $permission) {
            $this->middleware($role)->only($permission);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function synchronize()
    {
        if(Auth::user()->id == 1){
            $temp = Rawan::get();
            foreach($temp as $data){
                if(isset($data->ruasJalan)){
                    $data->sup_id = $data->ruasJalan->data_sup->id;
                    $data->kota_id = $data->ruasJalan->kota_id;
                    $data->save();
                }else{
                    if($data->foto)
                    Storage::delete('public/'.$data->foto);
                    
                    $data->delete();
                }
            }
            storeLogActivity(declarLog(1, 'Singkronisasi Data Rawan Bencana', 'Singkronisasi Data Rawan Bencana',1));
            $color = "success";
            $msg = "Singkronisasi Sudah Dilakukan !";
        }else{
            storeLogActivity(declarLog(1, 'Singkronisasi Data Rawan Bencana', 'Wrong Access'));
            $color = "danger";
            $msg = "Somethink When Wrong !";
        }
        return back()->with(compact('color', 'msg'));
        
    }
    public function index()
    {
        $response = [
            'status' => 'false',
            'data' => []
        ];
        $rawanbencana = new RawanBencana();
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $laporan = $rawanbencana->where('uptd_id', $uptd_id);
        }
        $rawanbencana = $rawanbencana->get();
        return view('admin.master.rawanbencana.index', compact('rawanbencana','icon'));
    }


    public function getData()
    {
        $rawan = DB::table('master_rawan_bencana');
        $rawan = $rawan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'master_rawan_bencana.ruas_jalan')->select('master_rawan_bencana.*', 'master_ruas_jalan.nama_ruas_jalan');
        $ruas = DB::table('master_ruas_jalan');
        // print_r(Auth::user()->internalRole->uptd);
        $uptd = DB::table('landing_uptd');
        $sup = DB::table('utils_sup');

        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $rawan = $rawan->where('master_rawan_bencana.uptd_id', $uptd_id);
            $ruas = $ruas->where('master_ruas_jalan.uptd_id', $uptd_id);
            $sup = $sup->where('uptd_id', $uptd_id);
            $uptd= $uptd->where('id', $uptd_id);
            if (count(Auth::user()->ruas) > 0) {
                $ruas = $ruas->whereIn('master_ruas_jalan.id_ruas_jalan', Auth::user()->ruas->pluck('id_ruas_jalan')->toArray());
            }
            if(isset(Auth::user()->data_sup)){
                $sup = $sup->where('id', Auth::user()->data_sup->id);
            }
        }
        $rawan = $rawan->get();
        $ruas = $ruas->get();
        $sup = $sup->get();
        $uptd = $uptd->get();

        $icon = DB::table('icon_titik_rawan_bencana')->get();
        // dd(isset(Auth::user()->data_sup));
        return view('admin.master.rawanbencana.index', compact('rawan', 'ruas', 'uptd','icon','sup'));
    }
    public function getDataSUP($id){
        $sup = DB::table('utils_sup as a')
        ->distinct()
        ->where('a.uptd_id',$id)
        ->get();
        return response()->json(['sup'=>$sup], 200);
    }
    public function getURL($id){
        $icon = DB::table('icon_titik_rawan_bencana as a')
        ->distinct()
        ->where('a.id',$id)
        ->get();
        return response()->json(['icon'=>$icon], 200);
    }
    public function editData($id)
    {
        $rawan = DB::table('master_rawan_bencana')->where('master_rawan_bencana.id', $id)
        // ->leftJoin('icon_titik_rawan_bencana', 'icon_titik_rawan_bencana.id', '=', 'master_rawan_bencana.icon_id')
        // ->select('master_rawan_bencana.*', 'icon_titik_rawan_bencana.id as icon_id')
        ->first();
        // print_r(Auth::user()->internalRole->uptd);
        $uptd = DB::table('landing_uptd');
        $ruas = DB::table('master_ruas_jalan')->where('uptd_id',$rawan->uptd_id);
        $sup = DB::table('utils_sup');

        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $ruas = $ruas->where('master_ruas_jalan.uptd_id', $uptd_id);
            $sup = $sup->where('uptd_id', $uptd_id);
            $uptd= $uptd->where('id', $uptd_id);
            if (count(Auth::user()->ruas) > 0) {
                $ruas = $ruas->whereIn('master_ruas_jalan.id_ruas_jalan', Auth::user()->ruas->pluck('id_ruas_jalan')->toArray());
            }
            if(isset(Auth::user()->data_sup)){
                $sup = $sup->where('id', Auth::user()->data_sup->id);
            }
        }
        $ruas = $ruas->get();
        $sup = $sup->get();
        $uptd = $uptd->get();

        $icon = DB::table('icon_titik_rawan_bencana')->get();

        $icon_curr = DB::table('icon_titik_rawan_bencana as a')
        ->distinct()
        ->where('a.id',$rawan->icon_id)
        ->first();
        return view('admin.master.rawanbencana.edit', compact('rawan', 'ruas', 'uptd','sup','icon','icon_curr'));
    }
    public function createData(Request $req)
    {
        $rawan = $req->except('_token');
        // $rawan['slug'] = Str::slug($req->nama, '');
        $rawan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        $ruas = RuasJalan::where('id_ruas_jalan',$rawan['ruas_jalan'])->first();
        $rawan['no_ruas'] = $ruas->id_ruas_jalan;
        $rawan['ruas_jalan'] = $ruas->nama_ruas_jalan;
        $rawan['sup_id'] = $ruas->data_sup->id;
        $rawan['kota_id'] = $ruas->kota_id;
        $rawan['created_at'] = Carbon::now();
        $rawan['created_by'] = Auth::user()->id;
        // dd($rawan);
        if ($req->foto != null) {
            $path = 'rawanbencana/' . Str::snake(date("YmdHis") . ' ' . $req->foto->getClientOriginalName());
            $req->foto->storeAs('public/', $path);
            $rawan['foto'] = $path;
        }
        $icon_image = DB::table('icon_titik_rawan_bencana')->where('id',$req->icon_id)->get();
        $rawan['icon_image'] = $icon_image[0]->icon_image;
        DB::table('master_rawan_bencana')->insert($rawan);

        $color = "success";
        $msg = "Berhasil Menambah Data Rawan Bencana";
        return back()->with(compact('color', 'msg'));
    }
    public function updateData(Request $req)
    {
        $rawan = $req->except('_token', 'id');
        $rawan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        $ruas = RuasJalan::where('id_ruas_jalan',$rawan['ruas_jalan'])->first();
        $rawan['no_ruas'] = $ruas->id_ruas_jalan;
        $rawan['ruas_jalan'] = $ruas->nama_ruas_jalan;
        $rawan['sup_id'] = $ruas->data_sup->id;
        $rawan['kota_id'] = $ruas->kota_id;
        $rawan['updated_at'] = Carbon::now();
        $rawan['updated_by'] = Auth::user()->id;

        // dd($rawan);
        if ($req->foto != null) {
            $path = 'rawanbencana/' . Str::snake(date("YmdHis") . ' ' . $req->foto->getClientOriginalName());
            $req->foto->storeAs('public/', $path);
            $rawan['foto'] = $path;
        }

        $old = DB::table('master_rawan_bencana')->where('id', $req->id)->first();
        if($old->foto)
        Storage::delete('public/'.$old->foto);

        $icon_image = DB::table('icon_titik_rawan_bencana')->where('id',$req->icon_id)->get();
        $rawan['icon_image'] = $icon_image[0]->icon_image;

        DB::table('master_rawan_bencana')->where('id', $req->id)->update($rawan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Rawan Bencana";
        return redirect(route('getDataBencana'))->with(compact('color', 'msg'));
    }
    public function deleteData($id)
    {
        $old = DB::table('master_rawan_bencana')->where('id', $id);
        $old->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Rawan Bencana";
        return redirect(route('getDataBencana'))->with(compact('color', 'msg'));
    }

    public function json()
    {
        $rawanbencana = DB::table('master_rawan_bencana');
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $rawanbencana = $rawanbencana->where('uptd_id', $uptd_id);
            if(isset(Auth::user()->data_sup)){
                $rawanbencana = $rawanbencana->where('sup_id', Auth::user()->data_sup->id);
            }
            if (str_contains(Auth::user()->internalRole->role, 'Mandor')) {
                $rawanbencana = $rawanbencana->where('created_by', Auth::user()->id);

            } else if (isset(Auth::user()->data_sup)) {
                $rawanbencana = $rawanbencana->where('sup_id', Auth::user()->data_sup->id);

                if (count(Auth::user()->ruas) > 0) 
                    $rawanbencana = $rawanbencana->whereIn('no_ruas', Auth::user()->ruas->pluck('id_ruas_jalan')->toArray());
            }
              
        }
        return DataTables::of($rawanbencana)
            ->addIndexColumn()
            ->addColumn('imgbencana', function ($row) {
                $path_foto = explode('/',$row->foto);
                $img = '<img class="img-fluid" style="max-width: 100px" src="'. url('/storage/'.$row->foto) .'"  alt="'.end($path_foto).'" />';
                return $img;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';

                if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Update")) {
                    $btn = $btn . '<a href="' . route('editDataBencana', $row->id) . '"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-sm waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                }

                if (hasAccess(Auth::user()->internal_role_id, "Rawan Bencana", "Delete")) {
                    $btn = $btn . '<a href="#delModal" data-id="' . $row->id . '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-sm waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
                }
                $btn = $btn . '</div>';

                return $btn;
            })
            ->addColumn('uptd', function($row){
                return 'UPTD '.$row->uptd_id;
            })
            ->rawColumns(['action','imgbencana'])
            ->make(true);
    }
}
