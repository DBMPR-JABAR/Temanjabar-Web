<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    //
    public function slider()
    {
        $data = News::take(5)->latest()->get();
        if($data){
            return response()->json([
                'success'   => true,
                'message'   => 'Data Berita',
                'data'  => $data
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'Berita tidak ditemukan'
            ]);
        }
    }
    public function getAll()
    {
        $data = News::latest()->get();
        if($data){
            return response()->json([
                'success'   => true,
                'message'   => 'Data Berita',
                'data'  => $data
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'Berita tidak ditemukan'
            ]);
        }
    }
    public function show($slug)
    {
        $data = News::where('slug', $slug)->first();
        $publishedAt = $data->published_at;
        $data->publishedAtForHuman = Carbon::parse($publishedAt)->format('d F Y');
        $data->publishedBy;
        if($data){
            return response()->json([
                'success'   => true,
                'message'   => 'Data Berita',
                'data'  => $data
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'Berita tidak ditemukan'
            ]);
        }
    }
}
