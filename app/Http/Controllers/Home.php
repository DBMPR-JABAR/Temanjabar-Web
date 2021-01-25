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
}
