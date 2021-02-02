<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
// use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;

class PekerjaanController extends Controller
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
        
        $pekerjaan = new Pekerjaan();
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $laporan = $pekerjaan->where('UPTD', $uptd_id);
        }
        $pekerjaan = $pekerjaan->get();
        
        return view('admin.input.pekerjaan.index', compact('pekerjaan'));
    }


    public function getData()
    {
        $pekerjaan = DB::table('kemandoran');
        $pekerjaan = $pekerjaan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'kemandoran.ruas_jalan')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan');
        // print_r(Auth::user()->internalRole->uptd);
        $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
        
        if (Auth::user()->internalRole->uptd) {
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $uptd_id);
        }
        
        $pekerjaan = $pekerjaan->where('is_deleted', 0)->get();
        $ruas_jalan = DB::table('master_ruas_jalan');
        if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id', $uptd_id);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id', $uptd_id);
        }
        $sup = $sup->get();
        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();

        $mandor = DB::table('users')->where('user_role.role', 'like', 'mandor%');
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        $mandor = $mandor->get();

        $userUptd= DB::table('user_role')->where('id',Auth::user()->internal_role_id)->first();
        if($userUptd->uptd == NULL) $uptd = DB::table('landing_uptd')->get();
        else {
            $uptd = DB::table('landing_uptd')->where('slug',$userUptd->uptd);
        }
        //dd($uptd);
        return view('admin.input.pekerjaan.index', compact('pekerjaan', 'ruas_jalan', 'sup', 'uptd', 'mandor', 'jenis'));
    }
    public function editData($id)
    {
        $pekerjaan = DB::table('kemandoran')->where('id_pek', $id)->first();
        $ruas_jalan = DB::table('master_ruas_jalan');
        // if (Auth::user()->internalRole->uptd) {
        //     $ruas_jalan = $ruas_jalan->where('uptd_id', Auth::user()->internalRole->uptd);
        // }
        echo $pekerjaan->uptd_id;
        $ruas_jalan = $ruas_jalan->where('uptd_id', $pekerjaan->uptd_id);
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        $sup = $sup->where('uptd_id', $pekerjaan->uptd_id);

        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();


        $mandor = DB::table('users')->where('user_role.role', 'like', 'mandor%');
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        $mandor = $mandor->get();

        $sup = $sup->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.pekerjaan.edit', compact('pekerjaan', 'ruas_jalan', 'sup', 'uptd', 'jenis', 'mandor'));
    }

    public function materialData($id)
    {
        $pekerjaan = DB::table('kemandoran')->where('id_pek', $id)->first();
        // $pekerjaan = $pekerjaan->leftJoin('bahan_material', 'bahan_material.id_pek', '=', 'kemandoran.id_pek')->select('kemandoran.*', 'bahan_material.*');
        $ruas_jalan = DB::table('master_ruas_jalan');
        if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id', Auth::user()->internalRole->uptd);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id', Auth::user()->internalRole->uptd);
        }

        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();

        $material1 = DB::table('bahan_material')->where('id_pek', $id)->get();
        if (count($material1) > 0) {
            $material = DB::table('bahan_material')->where('id_pek', $id)->first();
        } else {
            $material = '';
        }

        $bahan = DB::table('item_bahan');
        $bahan = $bahan->get();

        $satuan = DB::table('item_satuan');
        $satuan = $satuan->get();


        $mandor = DB::table('users')->where('user_role.role', 'like', 'mandor%');
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        $mandor = $mandor->get();

        $sup = $sup->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.pekerjaan.material', compact('pekerjaan', 'ruas_jalan', 'sup', 'uptd', 'jenis', 'mandor', 'bahan', 'material', 'satuan'));
    }

    public function createData(Request $req)
    {
        $pekerjaan = $req->except(['_token']);
        // $pekerjaan['slug'] = Str::slug($req->nama, '');
        if ($req->foto_awal != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_awal'] = $path;
        }
        if ($req->foto_sedang != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_sedang->getClientOriginalName());
            $req->foto_sedang->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_sedang'] = $path;
        }
        if ($req->foto_akhir != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_akhir->getClientOriginalName());
            $req->foto_akhir->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_akhir'] = $path;
        }
        if ($req->video != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->video->getClientOriginalName());
            $req->video->storeAs('public/pekerjaan/', $path);
            $pekerjaan['video'] = $path;
        }
        $row = DB::table('kemandoran')->select('id_pek')->orderByDesc('id_pek')->limit(1)->first();

        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        $pekerjaan['tglreal'] = date('Y-m-d H:i:s');
        $pekerjaan['is_deleted'] = 0;
        $nomor = intval(substr($row->id_pek, strlen('CK-'))) + 1;
        $pekerjaan['id_pek'] = 'CK-' . str_pad($nomor, 6, "0", STR_PAD_LEFT);

        DB::table('kemandoran')->insert($pekerjaan);

        $color = "success";
        $msg = "Berhasil Menambah Data Pekerjaan";
        return back()->with(compact('color', 'msg'));
    }

    public function createDataMaterial(Request $req)
    {
        $pekerjaan = $req->except(['_token']);
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;

        DB::table('bahan_material')->insert($pekerjaan);

        $color = "success";
        $msg = "Berhasil Menambah Data Bahan Material";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }
    public function updateData(Request $req)
    {
        $pekerjaan = $req->except('_token', 'id_pek');
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;

        $old = DB::table('kemandoran')->where('id_pek', $req->id_pek)->first();
        if ($req->foto_awal != null) {
            $old->foto_awal ?? Storage::delete('public/pekerjaan/' . $old->foto_awal);

            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_awal'] = $path;
        }
        if ($req->foto_sedang != null) {
            $old->foto_sedang ?? Storage::delete('public/pekerjaan/' . $old->foto_sedang);

            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_sedang->getClientOriginalName());
            $req->foto_sedang->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_sedang'] = $path;
        }
        if ($req->foto_akhir != null) {
            $old->foto_akhir ?? Storage::delete('public/pekerjaan/' . $old->foto_akhir);

            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_akhir->getClientOriginalName());
            $req->foto_akhir->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_akhir'] = $path;
        }
        if ($req->video != null) {
            $old->video ?? Storage::delete('public/pekerjaan/' . $old->video);

            $path = Str::snake(date("YmdHis") . ' ' . $req->video->getClientOriginalName());
            $req->video->storeAs('public/pekerjaan/', $path);
            $pekerjaan['video'] = $path;
        }

        DB::table('kemandoran')->where('id_pek', $req->id_pek)->update($pekerjaan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Rawan Bencana";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }

    public function updateDataMaterial(Request $req)
    {
        $pekerjaan = $req->except('_token', 'id_pek');
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;

        DB::table('bahan_material')->where('id_pek', $req->id_pek)->update($pekerjaan);

        $color = "success";
        $msg = "Berhasil Mengubah Data Material";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }
    public function deleteData($id)
    {
        // $temp = DB::table('kemandoran')->where('id',$id)->first();
        $temp = DB::table('bahan_material')->where('id_pek', $id)->delete();
        $param['is_deleted'] = 1;
        $old = DB::table('kemandoran')->where('id_pek', $id)->update($param);

        $color = "success";
        $msg = "Berhasil Menghapus Data Pekerjaan";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }

    public function submitData($id)
    {
        // $temp = DB::table('kemandoran')->where('id',$id)->first();
        $param['rule'] = 'KSUP';
        $pekerjaan = DB::table('kemandoran')->where('id_pek', $id)->update($param);
        $material = DB::table('bahan_material')->where('id_pek', $id)->update($param);

        $color = "success";
        $msg = "Berhasil Melakukan Submit Data Material";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }

    public function json(Request $request)
    {
        $pekerjaan = DB::table('kemandoran');
        $pekerjaan = $pekerjaan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'kemandoran.ruas_jalan')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan');

        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $uptd_id);
        }
        $from = $request->year_from;
        $to = $request->year_to;
        $pekerjaan = $pekerjaan->whereRaw("YEAR(tanggal) BETWEEN $from AND $to");
        $pekerjaan = $pekerjaan->where('is_deleted', 0)->get();

        return DataTables::of($pekerjaan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';

                if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Update")) {
                    $btn = $btn . '<a href="' . route('editDataPekerjaan', $row->id_pek) . '"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-sm waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                    $btn = $btn . '<a href="' . route('materialDataPekerjaan', $row->id_pek) . '"><button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="tooltip" title="Material"><i class="icofont icofont-list"></i></button></a>';
                }

                if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Delete")) {
                    $btn = $btn . '<a href="#delModal" data-id="' . $row->id_pek . '" data-toggle="modal"><button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="tooltip" title="Hapus"><i class="icofont icofont-trash"></i></button></a>';
                }

                if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Update")) {
                    $btn = $btn . '<a href="#submitModal" data-id="' . $row->id_pek . '" data-toggle="modal"><button class="btn btn-success btn-sm waves-effect waves-light" data-toggle="tooltip" title="Submit"><i class="icofont icofont-check-circled"></i></button></a>';
                }

                $btn = $btn . '</div>';

                // $btn = '<a href="javascript:void(0)" class="btn btn-primary">' . $row->id . '</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
