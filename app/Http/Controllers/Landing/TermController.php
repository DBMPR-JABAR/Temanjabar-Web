<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Term;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TermController extends Controller
{
    //
    public function index()
    {
        $term = Term::first();
        return view('admin.landing.term.insert', compact('term'));
    }
    public function store(Request $request)
    {
        $slug = Str::slug($request->title);
        $term = Term::firstOrNew(['slug'=>$slug]);
        $term->created_by = Auth::user()->id;
        $term->title = $request->title;
        $term->content = $request->content;
        $term->save();
        $color = "success";
        $msg = "Berhasil diperbaharui";
        return redirect(route('term.index'))->with(compact('color', 'msg'));
    }
    public function show_masyarakat()
    {
        $term = Term::first();
        $publishedAt = $term->published_at;

        $publishedAtForHuman = Carbon::parse($publishedAt)->format('d F Y');

        return view('masyarakat.term.show', compact('term','publishedAtForHuman'));
    }
       
}
