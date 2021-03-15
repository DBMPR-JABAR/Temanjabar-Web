<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pengumuman = Announcement::latest('created_at')
        ->leftJoin('users','announcements.created_by','=','users.id')->select('announcements.*', 'users.name as nama_user')
        ->get();
        // dd($pengumuman);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $action = 'store';
        return view('admin.pengumuman.insert', compact('action'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'cover'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required',
            'content'       => '',
            'sent_to'       => 'required'
        ]);
        $pengumuman = [
            "title"=>$request->title, 
            "slug" =>Str::slug($request->title, '-'),
            "content"=>$request->content, 
            "sent_to"=>$request->sent_to,
            "created_by"=>Auth::user()->id,
            "updated_by"=>Auth::user()->id

        ];
       
        if ($request->cover != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $request->cover->getClientOriginalName());
            $request->cover->storeAs('public/pengumuman/', $path);
            $pengumuman['image'] = $path;
        }
        $title = "Pengumuman ".$request->title;
        $body = $request->content;
        $userPelapor = DB::table("users")->where('id',Auth::user()->id)->first()->id;
       
        $users = [$userPelapor];
        

        sendNotification($users,$title,$body);
        $announcement = Announcement::create($pengumuman)->save();
        // dd($pengumuman);


        if($announcement){
            //redirect dengan pesan sukses
            $color = "success";
            $msg = "Data Berhasil Disimpan!";
        }else{
            //redirect dengan pesan error
            $color = "danger";
            $msg = "Data Gagal Disimpan!";
        }
        return redirect()->route('announcement.index')->with(compact('color', 'msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
        // dd($announcement);
        $action = 'edit';
        return view('admin.pengumuman.insert', compact('action','announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
         //
         $this->validate($request,[
            'cover'         => 'image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required',
            'content'       => '',
            'sent_to'       => 'required'
        ]);
        $pengumuman = [
            "title"=>$request->title, 
            "slug" =>Str::slug($request->title, '-'),
            "content"=>$request->content, 
            "sent_to"=>$request->sent_to,
            "updated_by"=>Auth::user()->id

        ];
        // dd($announcement);
       
        if ($request->cover != null) {
            //remove old image
            Storage::disk('local')->delete('public/pengumuman/'.$announcement->image);
            
            $path = Str::snake(date("YmdHis") . ' ' . $request->cover->getClientOriginalName());
            $request->cover->storeAs('public/pengumuman/', $path);
            $pengumuman['image'] = $path;
        }
        
        $announcement = Announcement::findOrFail($announcement->id)
        ->update($pengumuman);
        // dd($pengumuman);
        if($announcement){
            //redirect dengan pesan sukses
            $color = "success";
            $msg = "Data Berhasil Diperbaharui!";
        }else{
            //redirect dengan pesan error
            $color = "danger";
            $msg = "Data Gagal Diperbaharui!";
        }
        return redirect()->route('announcement.index')->with(compact('color', 'msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $announcement = Announcement::findOrFail($id);
        // dd($announcement->id);
        Storage::disk('local')->delete('public/pengumuman/'.$announcement->image);
        $announcement = $announcement->delete();
        if($announcement){
            //redirect dengan pesan sukses
            $color = "success";
            $msg = "Data Berhasil Dihapus!";
        }else{
            //redirect dengan pesan error
            $color = "danger";
            $msg = "Data Gagal Dihapus!";
        }
        return redirect()->route('announcement.index')->with(compact('color', 'msg'));

    }
}
