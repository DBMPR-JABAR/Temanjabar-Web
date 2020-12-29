<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\DataTables;

class RawanBencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('admin.master.rawanbencana.index', compact('rawanbencana'));
    }


    public function getData()
    {
        $rawan = DB::table('master_rawan_bencana');
        $ruas = DB::table('master_ruas_jalan');
        $rawan = $rawan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'master_rawan_bencana.ruas_jalan')->select('master_rawan_bencana.*', 'master_ruas_jalan.nama_ruas_jalan');
        // print_r(Auth::user()->internalRole->uptd);
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $rawan = $rawan->where('master_rawan_bencana.uptd_id', $uptd_id);
            $ruas = $ruas->where('master_ruas_jalan.uptd_id', $uptd_id);
        }
        $rawan = $rawan->get();
        $ruas = $ruas->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.master.rawanbencana.index', compact('rawan', 'ruas', 'uptd'));
    }
    public function getDataSUP($id){
        $sup = DB::table('utils_sup as a')
        ->distinct()
        ->where('a.uptd_id',$id)
        ->get();
        return response()->json(['sup'=>$sup], 200);  
    }
    public function editData($id)
    {
        $rawan = DB::table('master_rawan_bencana')->where('id', $id)->first();
        $uptd = DB::table('landing_uptd')->get();

        $ruas = DB::table('master_ruas_jalan');
        $ruas = $ruas->where('master_ruas_jalan.uptd_id', $rawan->uptd_id);
        $ruas = $ruas->get();

        $sup = DB::table('utils_sup')
        ->where('uptd_id',$rawan->uptd_id)
        ->get();
        return view('admin.master.rawanbencana.edit', compact('rawan', 'ruas', 'uptd','sup'));
    }
    public function createData(Request $req)
    {
        $rawan = $req->except('_token');
        // $rawan['slug'] = Str::slug($req->nama, '');
        $rawan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;

        DB::table('master_rawan_bencana')->insert($rawan);

        $color = "success";
        $msg = "Berhasil Menambah Data Rawan Bencana";
        return back()->with(compact('color', 'msg'));
    }
    public function updateData(Request $req)
    {
        $rawan = $req->except('_token', 'id');
        $rawan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;

        $old = DB::table('master_rawan_bencana')->where('id', $req->id)->first();

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
        return DataTables::of(DB::table('master_rawan_bencana'))
            ->addIndexColumn()
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
            ->rawColumns(['action'])
            ->make(true);
    }
}
