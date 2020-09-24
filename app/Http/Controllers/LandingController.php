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

        DB::table('laporan')->insert($data);

        return redirect('/#laporan')->with(['color' => $color,'laporan-msg' => $msg]);
    }

    public function createPesan(Request $req)
    {
        $color = 'success';
        $msg = 'Berhasil menambahkan pesan, tanggapan akan dikirim melalui email anda';

        $data = $req->except(['_token']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('pesan')->insert($data);

        return redirect('/#kontak')->with(['color' => $color,'pesan-msg' => $msg]);

    }

// Lokasi: Admin Dashboard

    // TODO: Pesan
    public function getPesan()
    {
        $pesan = DB::table('pesan')->get();
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
        # code...
    }
    public function editSlideshow($id)
    {
        # code...
    }
    public function createSlideshow(Request $req)
    {
        # code...
    }
    public function updateSlideshow(Request $req)
    {
        # code...
    }
    public function deleteSlideshow($id)
    {
        # code...
    }

    // TODO: Fitur
    public function getFitur()
    {
        # code...
    }
    public function editFitur($id)
    {
        # code...
    }
    public function createFitur(Request $req)
    {
        # code...
    }
    public function updateFitur(Request $req)
    {
        # code...
    }
    public function deleteFitur($id)
    {
        # code...
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
