<?php

namespace App\Http\Controllers; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
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
        ->select('b.id','a.id as disposisi_id','b.tindak_lanjut','b.status as status_tindak_lanjut','b.persentase','b.keterangan as keterangan_tl', 'a.disposisi_code','a.dari','a.perihal','c.name as pengirim','a.tgl_surat','a.no_surat','a.tanggal_penyelesaian','a.status','a.file','a.created_date','a.created_by')
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
        $user_role = DB::table('user_role')->select('id', 'keterangan') ->where('parent_id', Auth::user()->internal_role_id);         
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

                      $tindaklanjut = DB::table('disposisi_tindak_lanjut as b')
                      ->distinct()              
                      ->select('b.id','a.id as disposisi_id','c.internal_role_id','c.name as penanggung_jawab','b.tindak_lanjut','b.status as status_tindak_lanjut','b.persentase','b.keterangan as keterangan_tl', 'a.disposisi_code','a.dari','a.perihal','c.name as pengirim','a.file','b.created_date','b.created_by')
                                    ->join('disposisi as a','a.id','=','b.disposisi_id')
                                    ->join('users as c','b.created_by','=','c.id')
                              //      ->rightJoin('user_role as f','c.id','=','c.internal_role_id')
                                    
                                    ->where('a.id','=',$id  ) 
                                    ->orderBy('b.id','DESC')
                                    ->get();

      $penanggung_jawab = DB::table('disposisi_approved as a')              
      ->select( 'c.keterangan','b.name','a.created_date'  )
                     ->join('user_role as c','c.id','=','a.user_role_id')
                     ->join('users as b','b.id','=','a.user_id')
                    ->where('a.disposisi_id','=', $id) 
                    ->get();
 $unit_responsible = DB::table('disposisi_penanggung_jawab  as a')              
      ->select( 'c.keterangan', 'd.id as disposisi_id','a.user_role_id'   )
                     ->join('user_role as c','c.id','=','a.user_role_id')
                    
                     ->join('disposisi as d','d.disposisi_code','=','a.disposisi_code')
                    ->where('d.id','=', $id) 
                    ->get();

$unit = "";
        foreach($unit_responsible as $pj){
$unit.= "<span>".$pj->keterangan."</span>".$this->getPersentase($pj->disposisi_id, $pj->user_role_id)."<br/>";

        }

        return view('admin.disposisi.detail',
                [
                    'tindaklanjut' => $tindaklanjut,
                    'detail_disposisi' => $detail_disposisi,
                    'penanggung_jawab' =>  $penanggung_jawab,
                    'unitData' => $unit
                ]);              
    }

    public function getPersentase($id, $role_id){
        $tl = DB::table('disposisi_tindak_lanjut  as a')              
      ->select( 'a.persentase', 'a.id' )
      ->join('users as b','b.id','=','a.created_by')               
      ->join('user_role as c','c.id','=','b.internal_role_id')
      ->where('a.disposisi_id','=',$id) 
       ->where('b.internal_role_id','=',$role_id)->orderBy('a.id','desc') ->first();
return !empty($tl->persentase) ? "(".$tl->persentase."%)" : "(0%)";
                    
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
        if(file != null){
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
        $disposisi['pengirim'] = $this->getPengirim(Auth::user()->id);
        $disposisi['type_mail'] ="Disposisi";
        $disposisi['mail_to'] = "izqfly@gmail.com";
        $disposisi['mail_from'] = "zanmit.consultant@gmail.com";
        $disposisi['date_now'] = date('d-m-Y H:i:s');
        $disposisi['instruksi'] = "ditindaklanjuti";
        //dispatch(new SendEmail($disposisi)); //send notification
        //DB::commit(); //commit transaction  

        $this->sendMail($request);
        $color = "success";
        $msg = "Berhasil Menambah Data Disposisi";
        return back()->with(compact('color', 'msg'));
    }
    public function getPengirim($id){
        $pengirim = DB::table('users as a')
        ->distinct()              
        ->select('a.name','b.keterangan')
                      ->join('user_role as b','b.id','=','a.internal_role_id')
                      ->where('a.id','=', $id) 
                      ->first();
      return $pengirim->name.' ('.$pengirim->keterangan.')';
    }

    public function sendMail($data){

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
        $disposisi['tindak_lanjut'] = $request->tindak_lanjut;
        $disposisi['status'] = $request->status;
        $disposisi['keterangan'] = $request->keterangan; 
        $disposisi['persentase'] = $request->persentase; 
        $disposisi['created_by'] = Auth::user()->id;
        $disposisi['created_date'] = date("YmdHis"); 
        DB::table('disposisi_tindak_lanjut')->insert($disposisi); 
 
        $datad['status'] = '3';
        DB::table('disposisi')->where('id',$request->disposisi_id)->update($datad); 

        $color = "success";
        $msg = "Berhasil Menambah Data Tindak Lanjut";
        return back()->with(compact('color', 'msg'));
    }

    public function getDaftarDisposisiInstruksi(){
        $instruksi = DB::table('master_disposisi_instruksi as a')
        ->distinct()              
        ->select('a.id','a.jenis_instruksi','a.keterangan')
        ->get();
        return view('admin.disposisi.instruksi',
                [
                    'instruksi' => $instruksi
                ]);
    }
    public function createInstruksi(Request $request)
    { 

        $disposisi['jenis_instruksi'] = $request->jenis_instruksi;
        $disposisi['keterangan'] = $request->ket;
        DB::table('master_disposisi_instruksi')->insert($disposisi); 

        $color = "success";
        $msg = "Berhasil Menambah Data Disposisi Instruksi";
        return back()->with(compact('color', 'msg'));
    }
    public function getDetailDisposisiInstruksi($id){
         
        $detail_disposisi_instruksi = DB::table('master_disposisi_instruksi as a')
        ->distinct()              
        ->select('a.id','a.jenis_instruksi','a.keterangan')
                      ->where('a.id','=', $id) 
                      ->first();

        return view('admin.disposisi.detail-instruksi',
                [
                    'detail_disposisi_instruksi' => $detail_disposisi_instruksi
                ]);              
    }
    public function getDataDisposisiInstruksi(Request $request){
         
        $detail_disposisi_instruksi = DB::table('master_disposisi_instruksi as a')
        ->distinct()              
        ->select('a.id','a.jenis_instruksi','a.keterangan')
                      ->where('a.id','=', $request->id) 
                      ->first();

        return response()->json(["data" => $detail_disposisi_instruksi], 200)     ;        
    }
    public function updateDisposisiInstruksi(Request $request)
    {   
        $disposisi['jenis_instruksi'] = $request->jenis_instruksi;
        $disposisi['keterangan'] = $request->ket;
        DB::table('master_disposisi_instruksi')->where('id',$request->id)->update($disposisi); 

        $color = "success";
        $msg = "Berhasil Update Data Disposisi Instruksi";
        return back()->with(compact('color', 'msg'));
    }
    public function deleteDisposisiInstruksi($id){
         
        $disposisi_instruksi = DB::table('master_disposisi_instruksi');
        $data = $disposisi_instruksi->where('id',$id);
        $data->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Disposisi Instruksi";
        return back()->with(compact('color', 'msg'));        
    }
}
