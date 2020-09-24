<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{

// Lokasi: Landing Page

    // GET
    public function index()
    {
        $profil = DB::table('landing_profil')->where('id',1)->first();
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
        # code...
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
    public function addSlideshow()
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
    public function addFitur()
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
        # code...
    }
    public function addUPTD()
    {
        # code...
    }
    public function editUPTD($id)
    {
        # code...
    }
    public function createUPTD(Request $req)
    {
        # code...
    }
    public function updateUPTD(Request $req)
    {
        # code...
    }
    public function deleteUPTD($id)
    {
        # code...
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

        // Cara 2
        $data = $req->except(['_token', 'agreed']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
    }
}
