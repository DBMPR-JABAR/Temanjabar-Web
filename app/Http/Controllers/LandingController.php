<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LandingController extends Controller
{

// Lokasi: Landing Page

    // GET
    public function index()
    {
        $profil = DB::table('landing_profil')->where('id',1)->first();

        // Compact mengubah variabel profil untuk dijadikan variabel yang dikirim
        return view('landing.index', compact('profil'));
    }
    // public function login()
    // {
    //     $profil = DB::table('landing_profil')->where('id',1)->first();

    //     return view('landing.login', compact('login'));
    // }
    public function paketPekerjaan()
    {
        $profil = DB::table('landing_profil')->where('id',1)->first();
        return view('landing.paket-pekerjaan',compact('profil'));
    }
    public function progressPekerjaan()
    {
        $profil = DB::table('landing_profil')->where('id',1)->first();
        return view('landing.progress-pekerjaan',compact('profil'));
    }

    // POST
    public function createLaporan(Request $req)
    {
        $color = 'success';
        $msg = 'Berhasil menambahkan laporan, tanggapan akan dikirim melalui email anda';

        $data = $req->except(['_token', 'agreed']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('monitoring_laporan_masyarakat')->insert($data);

        return redirect('/#laporan')->with(['color' => $color,'laporan-msg' => $msg]);
    }

    public function createPesan(Request $req)
    {
        $color = 'success';
        $msg = 'Berhasil menambahkan pesan, tanggapan akan dikirim melalui email anda';

        $data = $req->except(['_token']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('landing_pesan')->insert($data);

        return redirect('/#kontak')->with(['color' => $color,'pesan-msg' => $msg]);

    }

// Lokasi: Admin Dashboard

    // TODO: Pesan
    public function getPesan()
    {
        $pesan = DB::table('landing_pesan')->get();
        return view('admin.landing.pesan',compact('pesan'));
    }

    // TODO: Profil
    public function getProfil()
    {
        $profil = DB::table('landing_profil')->where('id',1)->first();
        return view('admin.landing.profil',compact('profil'));
    }
    public function updateProfil(Request $req)
    {
        $color = 'success';
        $msg = 'Berhasil mengubah data profil';

        $data = $req->except('_token','gambar');
        DB::table('landing_profil')->where('id',1)->update($data);

        return back()->with(compact('color','msg'));
    }

    // TODO: Slideshow
    public function getSlideshow()
    {
        $slideshow = DB::table('landing_slideshow')->get();
        return view('admin.landing.slideshow.index',compact('slideshow'));
    }
    public function editSlideshow($id)
    {
        $slideshow = DB::table('landing_slideshow')->where('id',$id)->first();
        return view('admin.landing.slideshow.edit',compact('slideshow'));
    }
    public function createSlideshow(Request $req)
    {
        $slideshow = $req->except('_token','gambar');

        DB::table('landing_slideshow')->insert($slideshow);

        $color = "success";
        $msg = "Berhasil Menambah Data Slideshow";
        return back()->with(compact('color','msg'));
    }
    public function updateSlideshow(Request $req)
    {
        $slideshow = $req->except('_token','gambar','id');
        DB::table('landing_slideshow')->where('id',$req->id)->update($slideshow);

        $color = "success";
        $msg = "Berhasil Mengubah Data Slideshow";
        return redirect(route('getLandingSlideshow'))->with(compact('color','msg'));
    }
    public function deleteSlideshow($id)
    {
        DB::table('landing_slideshow')->where('id',$id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Slideshow";
        return redirect(route('getLandingSlideshow'))->with(compact('color','msg'));
    }

    // TODO: Fitur
    public function getFitur()
    {
        $fitur = DB::table('landing_fitur')->get();
        return view('admin.landing.fitur.index',compact('fitur'));
    }
    public function editFitur($id)
    {
        $fitur  = DB::table('landing_fitur')->where('id',$id)->first();
        return view('admin.landing.fitur.edit',compact('fitur'));
    }
    public function createFitur(Request $req)
    {
        $fitur = $req->except('_token','icon');

        DB::table('landing_fitur')->insert($fitur);

        $color = "success";
        $msg = "Berhasil Menambah Data Fitur";
        return back()->with(compact('color','msg'));
    }
    public function updateFitur(Request $req)
    {
        $fitur = $req->except('_token','icon','id');

        DB::table('landing_fitur')->where('id',$req->id)->update($fitur);

        $color = "success";
        $msg = "Berhasil Mengubah Data Fitur";
        return redirect(route('getLandingFitur'))->with(compact('color','msg'));
    }
    
    public function deleteFitur($id)
    {
        DB::table('landing_fitur')->where('id',$id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Fitur";
        return redirect(route('getLandingFitur'))->with(compact('color','msg'));
    }

    // TODO: UPTD
    public function getUPTD()
    {
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.landing.uptd.index',compact('uptd'));
    }
    public function editUPTD($id)
    {
        $uptd = DB::table('landing_uptd')->where('id',$id)->first();
        return view('admin.landing.uptd.edit',compact('uptd'));
    }
    public function createUPTD(Request $req)
    {
        $uptd = $req->except('_token','gambar');
        $uptd['slug'] = Str::slug($req->nama);

        DB::table('landing_uptd')->insert($uptd);

        $color = "success";
        $msg = "Berhasil Menambah Data UPTD";
        return back()->with(compact('color','msg'));
    }
    public function updateUPTD(Request $req)
    {
        $uptd = $req->except('_token','gambar','id');
        $uptd['slug'] = Str::slug($req->nama);

        DB::table('landing_uptd')->where('id',$req->id)->update($uptd);

        $color = "success";
        $msg = "Berhasil Mengubah Data UPTD";
        return redirect(route('getLandingUPTD'))->with(compact('color','msg'));
    }
    public function deleteUPTD($id)
    {
        DB::table('landing_uptd')->where('id',$id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data UPTD";
        return redirect(route('getLandingUPTD'))->with(compact('color','msg'));
    }

// DEBUG
    public function howToInsert(Request $req)
    {
        // Cara 1
        $data = [
            'nama' => $req->nama,
            'nik' => $req->nik,
            'telp' => $req->telp,
            'email' => $req->email,
            'jenis' => $req->jenis,
            'deskripsi' => $req->deskripsi,
            'lat' => $req->lat,
            'long' => $req->long,
            'uptd_id' => $req->uptd_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        // Cara 2 : Pastikan input name sama dengan kolom tabel
        $data = $req->except(['_token', 'input_name_lain']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
    }
}
