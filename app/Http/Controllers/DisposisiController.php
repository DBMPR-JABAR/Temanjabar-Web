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

    public function getInboxDisposisi(){
        $disposisi = DB::table('disposisi as a')
        ->distinct()              
        ->select('a.id','a.disposisi_code','a.dari','a.perihal','c.name as pengirim','a.tgl_surat','a.no_surat','a.tanggal_penyelesaian','a.status','a.file','a.created_date','a.created_by')
                      ->join('disposisi_penanggung_jawab as b','b.disposisi_code','=','a.disposisi_code')
                      ->join('users as c','a.created_by','=','c.id')
                      ->where('b.user_role_id','=',Auth::user()->internal_role_id  ) 
                      ->orderBy('a.id','DESC')
                      ->get();

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

        return view('admin.disposisi.inbox',
            [
                'disposisi' => $disposisi,
                'disposisi_kepada' => $disposisi_kepada,
                'jenis_instruksi_select' => $jenis_instruksi_select,
               
            ]);
    }
    public function getDisposisiTindakLanjut(){
        $tindaklanjut = DB::table('disposisi_tindak_lanjut as b')
        ->distinct()              
        ->select('b.id','b.tindak_lanjut','b.status as status_tindak_lanjut','b.prosentase','b.keterangan as keterangan_tl', 'a.disposisi_code','a.dari','a.perihal','c.name as pengirim','a.tgl_surat','a.no_surat','a.tanggal_penyelesaian','a.status','a.file','a.created_date','a.created_by')
                      ->join('disposisi as a','a.id','=','b.disposisi_id')
                      ->join('users as c','a.created_by','=','c.id')
                      ->where('b.created_by','=',Auth::user()->id  ) 
                      ->orderBy('b.id','DESC')
                      ->get();

        
       

        return view('admin.disposisi.tindaklanjut',
            [
                'tindaklanjut' => $tindaklanjut  
               
            ]);
    }

    public function getDaftarDisposisi()
    {

        $disposisi = DB::table('disposisi as a')
        ->distinct()              
        ->select('a.id','a.disposisi_code','a.dari','a.perihal','a.tgl_surat','a.no_surat','a.tanggal_penyelesaian','a.status','a.file','a.created_date','a.created_by')
                      ->join('disposisi_penanggung_jawab as b','b.disposisi_code','=','a.disposisi_code')
                      ->where('a.created_by','=', Auth::user()->id) 
                      //->orWhere('b.user_role_id','=',Auth::user()->role_id ) 
                      ->orderBy('a.id','DESC')
                      ->get();
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

    public function getDetailDisposisi($id){
         
        $detail_disposisi = DB::table('disposisi as a')
        ->distinct()              
        ->select('a.id','a.disposisi_code','c.name as pengirim','a.dari','a.perihal','a.tgl_surat','a.no_surat','a.tanggal_penyelesaian','a.status','a.file','a.created_date','a.created_by')
                      ->join('disposisi_penanggung_jawab as b','b.disposisi_code','=','a.disposisi_code')
                      ->join('users as c','a.created_by','=','c.id')
                      ->where('a.id','=', $id) 
                      ->first();

      $penanggung_jawab = DB::table('disposisi_approved as a')              
      ->select( 'c.keterangan','b.name','a.created_date'  )
                     ->join('user_role as c','c.id','=','a.user_role_id')
                     ->join('users as b','b.id','=','a.user_id')
                    ->where('a.disposisi_id','=', $id) 
                    ->get();


        return view('admin.disposisi.detail',
                [
                    'detail_disposisi' => $detail_disposisi,
                    'penanggung_jawab' =>  $penanggung_jawab,
                  
                ]);              
    }
    public function getAcceptedRequest($id){
         
          $data['status'] = '2';
          DB::table('disposisi')->where('id',$id)->update($data); 
          
        $data2['disposisi_id'] = $id;
        $data2['user_id'] = Auth::user()->id;  
        $data2['user_role_id'] = Auth::user()->internal_role_id; 
        $data2['created_date'] = date('Y-m-d H:i:s');
        DB::table('disposisi_approved')->insert($data2); 
        
        $color = "success";
        $msg = "Disposisi telah anda terima";
        return redirect(route('disposisi-masuk'))->with(compact('color', 'msg'));
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
            $path = 'disposisi/'.Str::snake(date("YmdHis").'/'.$request->file->getClientOriginalName());
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

    public function createTindakLanjut(Request $request)
    { 
        //
        if($request->file != null){
            $path = 'disposisi/tindak_lanjut/'.Str::snake(date("YmdHis").'/'.$request->file->getClientOriginalName());
            $request->file->storeAs('public/',$path);
            $disposisi ['file'] = $path;
        }
        $disposisi['disposisi_id'] = $request->disposisi_id;
        $disposisi['tindaklanjut'] = $request->tindaklanjut;
        $disposisi['status'] = $request->status;
        $disposisi['keterangan'] = $request->keterangan; 
        $disposisi['prosentase'] = $request->prosentase; 
         $disposisi['created_by'] = Auth::user()->id;
        $disposisi['created_date'] = date("YmdHis"); 
        DB::table('disposisi_tindak_lanjut')->insert($disposisi); 
 
        $color = "success";
        $msg = "Berhasil Menambah Data Tindak Lanjut";
        return back()->with(compact('color', 'msg'));
    }



}
