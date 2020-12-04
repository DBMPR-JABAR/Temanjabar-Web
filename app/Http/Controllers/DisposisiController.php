<?php

namespace App\Http\Controllers; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class DisposisiController extends Controller
{

// Lokasi: Landing Page

    // GET
    public function index()
    {
        $profil = DB::table('landing_profil')->where('id', 1)->first();
        $fitur = DB::table('landing_fitur')->get();
        $uptd = DB::table('landing_uptd')->get();
        $slideshow = DB::table('landing_slideshow')->get();
        $lokasi = DB::table('utils_lokasi')->get();
        $jenis_laporan = DB::table('utils_jenis_laporan')->get();

        // Compact mengubah variabel profil untuk dijadikan variabel yang dikirim
        return view('landing.index', compact('profil', 'fitur', 'uptd', 'slideshow', 'lokasi', 'jenis_laporan'));
    }
    public function getDaftarDisposisi()
    {

        $disposisi = DB::table('disposisi')->get();
        $disposisi_kepada = ""; 
        $jenis_instruksi_select = "";
        $user_role = DB::table('user_role')->select('id', 'keterangan');         
        $listUserRole = $user_role->get(); 
        foreach ($listUserRole as $role) {
            $disposisi_kepada .= '<option value="' . $role->id . '">' . $role->keterangan . '</option>';
        }
        $jenisInstruksi = DB::table('master_disposisi_instruksi')->select('id', 'jenis_instruksi');         
        $listJenisInstruksi = $jenisInstruksi->get(); 
        foreach ($listJenisInstruksi as $instruksi) {
            $jenis_instruksi_select .= '<option value="' . $instruksi->id . '">' . $instruksi->jenis_instruksi . '</option>';
        }

        return view('admin.disposisi.index',
            [
                'disposisi' => $disposisi,
                'disposisi_kepada' => $disposisi_kepada,
                'jenis_instruksi_select' => $jenis_instruksi_select
            ]);
    }
    public function saveTargetDisposisi($target,$code){
        for($i = 0; $i< count($target); $i++) { 
        $data['disposisi_code'] = $code;
        $data['user_role_id'] = $target[$i];
        DB::table('disposisi_penanggung_jawab')->insert($data); 
        }

    }
    public function saveJenisInstruksi($jenis,$code){
        for($i = 0; $i< count($jenis); $i++) { 
        $data['disposisi_code'] = $code; 
        $data['disposisi_instruksi_id'] = $jenis[$i];
        DB::table('disposisi_jenis_instruksi')->insert($data); 
        }
    }

    public function generateCode(){
        //$count = DB::table('visit_reservation')->count();
        $max = DB::table('disposisi')->max('id');
        $code = date('ymd').''.$max+1;
        return $code;
    }
    public function create(Request $request)
    { 
        //
        if($request->file != null){
            $path = 'disposisi/'.Str::snake(date("YmdHis").'/'.	$request->tgl_surat.'/'.$request->file->getClientOriginalName());
            $request->file->storeAs('public/',$path);
            $disposisi ['file'] = $path;
        }
        $code = $this->generateCode();
        
        $disposisi['disposisi_code'] = $code;
        $disposisi['dari'] = $request->dari;
        $disposisi['perihal'] = $request->perihal;
        $disposisi['tgl_surat'] = $request->tgl_surat; 
        $disposisi['no_surat'] = $request->no_surat; 
        $disposisi['tanggal_penyelesaian'] = $request->tanggal_penyelesaian;
        $disposisi['status'] ='1'; 
        $disposisi['created_by'] = Auth::user()->id;
        $disposisi['created_date'] = date("YmdHis"); 
        DB::table('disposisi')->insert($disposisi); 
        $this->saveTargetDisposisi($request->target_disposisi,$code);
        $this->saveJenisInstruksi($request->jenis_instruksi,$code);

        $color = "success";
        $msg = "Berhasil Menambah Data Disposisi";
        return back()->with(compact('color', 'msg'));
    }



}
