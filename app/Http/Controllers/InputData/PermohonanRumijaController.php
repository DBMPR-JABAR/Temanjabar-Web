<?php

namespace App\Http\Controllers\InputData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PermohonanRumijaController extends Controller
{
    public function __construct()
    {
        $roles = setAccessBuilder('Permohonan Rumija', ['create', 'store'], ['index'], ['edit', 'update'], ['destroy']);
        foreach ($roles as $role => $permission) {
            $this->middleware($role)->only($permission);
        }

        $this->forms = ['nomor', 'tanggal', 'sifat', 'perihal', 'nama_pemohon', 'alamat', 'nomor_dan_tanggal', 'surat_berkas', 'jenis_ijin', 'tipe_permohonan'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permohonan_rumija = DB::table('permohonan_rumija')->get();
        return view('admin.input_data.permohonan_rumija.index', compact('permohonan_rumija'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.input_data.permohonan_rumija.insert', ['action' => 'store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $selectedPersyaratanForm = json_decode($request->selectedPersyaratanForm);
            $persyaratan = [];
            foreach ($selectedPersyaratanForm->forms as $form) {
                $kode = $selectedPersyaratanForm->kode . '_' . $form->kode;
                if ($form->type != 'file') {
                    $persyaratan[$kode] = $request[$kode];
                } else {
                    if ($request->hasFile($kode)) {
                        $path = 'rumija/permohonan/' . Str::snake(date("YmdHis") . ' ' . $request->file($kode)->getClientOriginalName());
                        $request->file($kode)->storeAs('public/', $path);
                        $persyaratan[$kode] = $path;
                    }
                }
            }
            $permohonan_rumija = $request->only($this->forms);
            $permohonan_rumija['persyaratan'] = json_encode($persyaratan);
            DB::table('permohonan_rumija')->insert($permohonan_rumija);
            DB::commit();
            $color = "success";
            $msg = "Berhasil Menambah Data Permohonan Rumija";
            return redirect(route('permohonan_rumija.index'))->with(compact('color', 'msg'));
        } catch (\Th $e) {
            DB::rollBack();
            $color = "danger";
            $msg = "Terjadi Kesalahan";
            return redirect()->back()->withInput();
        }
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
        $permohonan_rumija = DB::table('permohonan_rumija')->where('id', $id)->first();
        return view('admin.input_data.permohonan_rumija.insert', ['action' => 'update', 'permohonan_rumija' => $permohonan_rumija]);
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
        DB::beginTransaction();
        try {
            $selectedPersyaratanForm = json_decode($request->selectedPersyaratanForm);
            $exist = json_decode(DB::table('permohonan_rumija')->where('id', $id)->first()->persyaratan, true);
            $persyaratan = [];
            foreach ($selectedPersyaratanForm->forms as $form) {
                $kode = $selectedPersyaratanForm->kode . '_' . $form->kode;
                if ($form->type != 'file') {
                    $persyaratan[$kode] = $request[$kode];
                } else {
                    if ($request->hasFile($kode)) {
                        $path = 'rumija/permohonan/' . Str::snake(date("YmdHis") . ' ' . $request->file($kode)->getClientOriginalName());
                        $request->file($kode)->storeAs('public/', $path);
                        $persyaratan[$kode] = $path;
                    } else if (isset($exist[$kode])) {
                        $persyaratan[$kode] = $exist[$kode];
                    }
                }
            }
            $permohonan_rumija = $request->only($this->forms);
            $permohonan_rumija['persyaratan'] = json_encode($persyaratan);
            DB::table('permohonan_rumija')->where('id', $id)->update($permohonan_rumija);
            DB::commit();
            $color = "success";
            $msg = "Berhasil Memperbaharui Data Permohonan Rumija";
            return redirect(route('permohonan_rumija.index'))->with(compact('color', 'msg'));
        } catch (\Th $e) {
            DB::rollBack();
            $color = "danger";
            $msg = "Terjadi Kesalahan";
            return redirect()->back()->withInput();
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
        $permohonan_rumija = DB::table('permohonan_rumija')->where('id', $id);
        $exist = $permohonan_rumija->first();
        foreach (json_decode($exist->persyaratan) as $key => $value) {
            if (strpos($value, 'rumija/permohonan/') !== false) {
                File::delete('storage/app/public/' . $value);
            }
        }
        $permohonan_rumija->delete();
        $color = "success";
        $msg = "Berhasil Menghapus Data Permohonan Rumija";
        return redirect(route('permohonan_rumija.index'))->with(compact('color', 'msg'));
    }
}
