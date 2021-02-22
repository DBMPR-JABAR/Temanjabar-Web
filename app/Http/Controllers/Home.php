<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function index()
    {
       
        // Compact mengubah variabel profil untuk dijadikan variabel yang dikirim
        return view('admin.home');
    }

    public function downloadFile()
    {
        $path = storage_path('app/public/manualbook.pdf');
        return response()->download($path);
        // return response()->download($myFile, $newName, $headers);
    }	
}
