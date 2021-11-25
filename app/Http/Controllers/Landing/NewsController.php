<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Model\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();
        return view('admin.landing.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = "store";
        return view('admin.landing.news.insert', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $news['user_id'] = Auth::user()->id;
        $news['slug'] = Str::slug($request->title);
        $news = array_merge($request->except('_token', 'thumbnail'), $news);
        $news = News::create($news);
        if ($request->hasFile('thumbnail')) {
            $news->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }
        $color = "success";
        $msg = "Berhasil menambahkan berita";
        return redirect(route('news.index'))->with(compact('color', 'msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::where('slug', $id)->first();
        $allNews = News::where('id', '!=', $news->id)->get();
        $publishedAt = $news->published_at;
        $publishedAtForHuman = Carbon::parse($publishedAt)->format('d F Y');
        $publishedBy = DB::table('users')->where('id', $news->user_id)->first();
        return view('admin.landing.news.show', compact('news', 'allNews', 'publishedAtForHuman','publishedBy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::find($id);
        $news->thumbnail = $news->getFirstMediaUrl('thumbnail', 'thumb');
        $action = "update";
        return view('admin.landing.news.insert', compact('news', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news['user_id'] = Auth::user()->id;
        $news['slug'] = Str::slug($request->title);
        $news = array_merge($request->except('_token', 'thumbnail'), $news);
        $news = News::find($id)->fill($news);
        $news->clearMediaCollection();
        if ($request->hasFile('thumbnail')) {
            $news->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }
        $news->save();
        $color = "success";
        $msg = "Berhasil memperbaharui berita";
        return redirect(route('news.index'))->with(compact('color', 'msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::find($id)->delete();
        $color = "success";
        $msg = "Berhasil memnghapus berita";
        return redirect(route('news.index'))->with(compact('color', 'msg'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('news/images'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('news/images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
