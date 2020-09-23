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
        return view('landing.index');
    }
    public function paketPekerjaan()
    {
        return view('landing.paket-pekerjaan');
    }
    public function progressPekerjaan()
    {
        return view('landing.progress-pekerjaan');
    }

    // POST
    public function tambahLaporan(Request $req)
    {
        $color = 'success';
        $msg = 'Berhasil menambahkan laporan, tanggapan akan dikirim melalui email anda';

        $data = $req->except(['_token', 'agreed']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('laporan')->insert($data);

        return redirect('/#laporan')->with(['color' => $color,'laporan-msg' => $msg]);
    }

    public function tambahPesan(Request $req)
    {
        $color = 'success';
        $msg = 'Berhasil menambahkan pesan, tanggapan akan dikirim melalui email anda';

        $data = $req->except(['_token']);
        $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('pesan')->insert($data);

        return redirect('/#kontak')->with(['color' => $color,'pesan-msg' => $msg]);

    }

    // Lokasi: Admin Dashboard
    public function getSlider()
    {

    }
    public function updateSlider(Request $req)
    {

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
