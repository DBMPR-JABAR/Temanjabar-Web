<?php

namespace App\Http\Controllers\InputData;

use App\User;
use App\Http\Controllers\Controller;
// use App\Model\DWH\RawanBencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class PekerjaanController extends Controller
{
    public function __construct()
    {
        $roles = setAccessBuilder('Pekerjaan', ['createData', 'createDataMaterial','submitData'], ['index','getData','statusData','materialData','show','detailPemeliharaan','json'], ['editData', 'updateData','updateDataMaterial'], ['deleteData']);
        foreach ($roles as $role => $permission) {
            $this->middleware($role)->only($permission);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'status' => 'false',
            'data' => []
        ];

        $pekerjaan = new Pekerjaan();
        if (Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $laporan = $pekerjaan->where('UPTD', $uptd_id);
        }
        $pekerjaan = $pekerjaan->get();

        return view('admin.input.pekerjaan.index', compact('pekerjaan'));
    }
    public static function cekMaterial($id) {
        $cek = DB::table('bahan_material')->where('id_pek',$id)->exists();
        return $cek;
    }

    public function sendEmail($data, $to_email, $to_name, $subject){

        return Mail::send('mail.notifikasiStatusLapMandor', $data, function ($message) use ($to_name, $to_email,$subject) {
            $message->to($to_email, $to_name)->subject($subject);

            $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
        });
        // dd($mail);
    }
    public function setSendEmail($name, $id, $mandor, $jenis_pekerjaan, $uptd, $sup_mail, $status_mail, $keterangan, $to_email, $to_name,$subject){

        $temporari = [
            'name' =>Str::title($name),
            'id_pek' => $id,
            'nama_mandor' => Str::title($mandor),
            'jenis_pekerjaan' => Str::title($jenis_pekerjaan),
            'uptd' => Str::upper($uptd),
            'sup' => $sup_mail,
            'status' => $status_mail,
            'keterangan' => $keterangan
            ];

            // dd($subject);
            // dd($item);
            $mail = $this->sendEmail($temporari, $to_email, $to_name, $subject);
    }
    public function getData()
    {

        if( Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor')||str_contains(Auth::user()->internalRole->role,'Pengamat') || str_contains(Auth::user()->internalRole->role,'Kepala Satuan Unit Pemeliharaan') ){
            if(!Auth::user()->sup_id || !Auth::user()->internalRole->uptd ){
                // dd(Auth::user()->sup_id);
                $color = "danger";
                $msg = "Lengkapi Data Terlebih dahulu";
                if(Auth::user()->internalRole->uptd == null)
                    $msg = "Hubungi admin untuk melengkapi data jabatan";

                return redirect(url('admin/profile', Auth::user()->id))->with(compact('color', 'msg'));

            }
        }
        $pekerjaan = DB::table('kemandoran');

        $pekerjaan = $pekerjaan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'kemandoran.ruas_jalan')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan');
        // $pekerjaan = $pekerjaan->leftJoin('kemandoran_detail_status', 'kemandoran.id_pek', '=','kemandoran_detail_status.id_pek')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan','kemandoran_detail_status.*');

        if (Auth::user() && Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $uptd_id);
            if(str_contains(Auth::user()->internalRole->role,'Mandor')){
                $pekerjaan = $pekerjaan->where('kemandoran.user_id',Auth::user()->id);
            }else if(Auth::user()->sup_id)
                $pekerjaan = $pekerjaan->where('kemandoran.sup_id',Auth::user()->sup_id);
        }
        // dd($pekerjaan);
        $pekerjaan = $pekerjaan->whereRaw("YEAR(tanggal) BETWEEN 2021 AND 2021");
        $pekerjaan = $pekerjaan->where('is_deleted', 0)->latest('tglreal')->get();
        // dd($pekerjaan);

        foreach($pekerjaan as $no =>$data){
            // echo "$data->id_pek<br>";

            $data->status = "";

            $detail_adjustment=DB::table('kemandoran_detail_status')->where('id_pek',$data->id_pek);
            $input_material= $this->cekMaterial($data->id_pek);
            if($input_material){
                $tempuser= DB::table('users')
                ->leftJoin('user_role','users.internal_role_id','=','user_role.id')->where('users.id',$data->user_id);
                if($tempuser->exists()){
                    $tempuser=$tempuser->first();
                    $data->status = $tempuser;
                    $data->status->status="";
                }
            }
            $data->input_material = $input_material;
            $data->keterangan_status_lap= $detail_adjustment->exists();
            if($detail_adjustment->exists()){
                $detail_adjustment=$detail_adjustment
                ->leftJoin('users','users.id','=','kemandoran_detail_status.adjustment_user_id')
                ->leftJoin('user_role','users.internal_role_id','=','user_role.id');

                if($detail_adjustment->count() > 1){
                    $detail_adjustment=$detail_adjustment->get();
                    foreach($detail_adjustment as $num => $data1){
                        $temp = $data1;
                    }
                    $data->status=$temp;
                    // dd($data);
                }else{
                    $detail_adjustment=$detail_adjustment->first();
                    $data->status=$detail_adjustment;
                }
                $temp=explode(" - ",$data->status->role);
                $data->status->jabatan=$temp[0];
            }

            // echo "$data->id_pek<br>";


        }
        // dd(Carbon::now());
        // print_r(Auth::user()->internal_role_id);
        // dd($pekerjaan);
        $ruas_jalan = DB::table('master_ruas_jalan');
        if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id', $uptd_id);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id', $uptd_id);
        }
        $sup = $sup->get();
        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();

        $mandor = DB::table('users')->where('user_role.role', 'like', '%mandor%');
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        if( Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor')||str_contains(Auth::user()->internalRole->role,'Pengamat') || str_contains(Auth::user()->internalRole->role,'Kepala Satuan Unit Pemeliharaan') ){
            $mandor = $mandor->where('sup_id',Auth::user()->sup_id);
        }
        $mandor = $mandor->get();

        $userUptd= DB::table('user_role')->where('id',Auth::user()->internal_role_id)->first();
        if($userUptd->uptd == NULL) $uptd = DB::table('landing_uptd')->get();
        else {
            $uptd = DB::table('landing_uptd')->where('slug',$userUptd->uptd);
        }
        //dd($uptd);
        $kemandoran = DB::table('kemandoran');

        foreach($pekerjaan as $item){
            if($item->mail == 1){
                $next_user = DB::table('users')->where('internal_role_id',$item->status->parent)->where('sup_id',$item->status->sup_id)->get();
                // dd($next_user);
                $item->status->next_user = $next_user;

                $name =Str::title($item->status->name);
                $id_pek = $item->id_pek;
                $nama_mandor = Str::title($item->nama_mandor);
                $jenis_pekerjaan = Str::title($item->paket);
                $uptd = Str::upper($item->status->uptd);
                $sup_mail = $item->sup;
                $status_mail = "Submitted";
                $keterangan = "Silahkan menunggu sampai semua menyetujui / Approved";
                $subject = "Status Laporan $item->id_pek-Submitted";
                if(str_contains($item->status->status,'Edited')){
                    // dd($item);
                    $status_mail = $item->status->status;
                    $subject = "Status Laporan $item->id_pek-".$item->status->status;
                }

                $to_email = $item->status->email;
                $to_name = $item->nama_mandor;
                // dd($subject);
                // dd($item);
                $mail = $this->setSendEmail($name, $id_pek, $nama_mandor, $jenis_pekerjaan, $uptd, $sup_mail, $status_mail, $keterangan, $to_email, $to_name, $subject);
                if($item->status->next_user != ""){
                    foreach($item->status->next_user as $no =>$item1){
                        // dd($item->email);
                        $to_email =$item1->email;
                        $to_name = $item1->name;

                            $name =Str::title($item1->name);
                            $id_pek = $item->id_pek;
                            $nama_mandor = Str::title($item->nama_mandor);
                            $jenis_pekerjaan = Str::title($item->paket);
                            $uptd = Str::upper($item->status->uptd);
                            $sup_mail = $item->sup;

                            $keterangan = "Silahkan ditindak lanjuti";

                        $mail = $this->setSendEmail($name, $id_pek, $nama_mandor, $jenis_pekerjaan, $uptd, $sup_mail, $status_mail, $keterangan, $to_email, $to_name, $subject);

                        // $mail = $this->sendEmail($temporari1, $to_email, $to_name, $subject);

                    }
                }
                if($kemandoran->where('id_pek',$item->id_pek)->where('mail', $item->mail)->exists()){
                    $mail['mail'] = 2;
                    $kemandoran->update($mail);
                }



            }

        }
        // $kode_otp = rand(100000, 999999);
    //    echo Auth::user()->internalRole->id;
    //    echo Auth::user()->sup;
    // echo Auth::user()->internalRole->role;
    //    dd($pekerjaan);
        $approve = 0;
        $reject = 0;
        $submit = 0;
        $not_complete = 0;

        $rekaps = DB::table('kemandoran')
        ->leftJoin('kemandoran_detail_status','kemandoran_detail_status.id_pek','=','kemandoran.id_pek')
        ->select('kemandoran.*','kemandoran_detail_status.status',DB::raw('max(kemandoran_detail_status.id ) as status_s'), DB::raw('max(kemandoran_detail_status.id ) as status_s'))
        ->groupBy('kemandoran.id_pek');
        // ->where('kemandoran_detail_status.status','Approved')

        if (Auth::user() && Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $rekaps = $rekaps->where('kemandoran.uptd_id', $uptd_id);
            if(str_contains(Auth::user()->internalRole->role,'Mandor')){
                $rekaps = $rekaps->where('kemandoran.user_id',Auth::user()->id);
            }else if(Auth::user()->sup_id)
                $rekaps = $rekaps->where('kemandoran.sup_id',Auth::user()->sup_id);
        }

        $rekaps=$rekaps->get();
        foreach($rekaps as $it){
                    // echo $it->status.' | '.$it->id_pek.'<br>';

            $it->status_material = DB::table('bahan_material')->where('id_pek', $it->id_pek)->exists();

            $rekaplap = DB::table('kemandoran_detail_status')->where('id', $it->status_s)->pluck('status')->first();
            $it->status = $rekaplap;
            if(($it->status == "Approved"||$it->status == "Rejected" ||$it->status == "Edited") || $it->status_material){
                if($it->status == "Approved"){
                    $approve+=1;
                    // echo $it->status.' | '.$it->id_pek.'<br>';
                }else if($it->status == "Rejected" ||$it->status == "Edited"){
                    $reject+=1;
                    // echo $it->status.' | '.$it->id_pek.'<br>';
                }else
                    $submit+=1;

            }else
                $not_complete+=1;

            // echo $it->id_pek.' | '.$it->status.'<br>';

        }
            // dd($rekaps);
        $sum_report =[
            "approve" => $approve,
            "reject" => $reject,
            "submit" => $submit,
            "not_complete" => $not_complete

        ];

        return view('admin.input.pekerjaan.index', compact('pekerjaan', 'ruas_jalan', 'sup', 'uptd', 'mandor', 'jenis', 'sum_report'));
    }
    public function statusData($id){
        $adjustment=DB::table('kemandoran_detail_status')
        ->Join('kemandoran','kemandoran.id_pek','=','kemandoran_detail_status.id_pek')->where('kemandoran_detail_status.id_pek',$id)
        ->first();
        $det = $detail_adjustment=DB::table('kemandoran_detail_status')->where('id_pek',$id)->pluck('updated_at');
        $detail_adjustment=DB::table('kemandoran_detail_status')
        ->Join('kemandoran','kemandoran.id_pek','=','kemandoran_detail_status.id_pek')
        ->leftJoin('users','users.id','=','kemandoran_detail_status.adjustment_user_id')
        ->leftJoin('user_role','users.internal_role_id','=','user_role.id')->where('kemandoran_detail_status.id_pek',$id)
        ->get();
        // dd($det);
        foreach($detail_adjustment as $data){
            $temp=explode(" - ",$data->role);
            $data->jabatan=$temp[0];
        }
        return view('admin.input.pekerjaan.detail-status',compact('detail_adjustment','adjustment','det'));

    }
    public function editData($id)
    {

        $color = "danger";
        $msg = "Somethink when wrong!";
        $pekerjaan = DB::table('kemandoran')->where('id_pek', $id);
        if(!$pekerjaan->exists())
            return back()->with(compact('color', 'msg'));

        $pekerjaan = $pekerjaan->first();
        if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor'))
            if(Auth::user()->id != $pekerjaan->user_id){
                return back()->with(compact('color', 'msg'));
                // return redirect('admin/user/profile/'. auth()->user()->id)->with(['error' => 'Somethink when wrong!']);
            }

        $ruas_jalan = DB::table('master_ruas_jalan');
        // if (Auth::user()->internalRole->uptd) {
        //     $ruas_jalan = $ruas_jalan->where('uptd_id', Auth::user()->internalRole->uptd);
        // }
        // echo $pekerjaan->uptd_id;
        $ruas_jalan = $ruas_jalan->where('uptd_id', $pekerjaan->uptd_id);
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        $sup = $sup->where('uptd_id', $pekerjaan->uptd_id);

        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();

        $mandor = DB::table('users')->where('user_role.role', 'like', 'mandor%');
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        if( Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor')||str_contains(Auth::user()->internalRole->role,'Pengamat') || str_contains(Auth::user()->internalRole->role,'Kepala Satuan Unit Pemeliharaan') ){
            $mandor = $mandor->where('sup_id',Auth::user()->sup_id);
        }
        $mandor = $mandor->get();

        $sup = $sup->get();
        $uptd = DB::table('landing_uptd')->get();
        return view('admin.input.pekerjaan.edit', compact('pekerjaan', 'ruas_jalan', 'sup', 'uptd', 'jenis', 'mandor'));
    }

    public function createData(Request $req)
    {
        $pekerjaan = $req->except(['_token']);
        // dd($pekerjaan);
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        if($pekerjaan['uptd_id'])
            $pekerjaan['uptd_id'] = str_replace('uptd', '', $pekerjaan['uptd_id']);

        if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor')){
            $temp[0]=Auth::user()->name;
            $temp[1]=Auth::user()->id;
        }else
            $temp=explode(",",$pekerjaan['nama_mandor']);
        // dd($pekerjaan['sup']);
        if(!Auth::user()->internalRole->uptd){
            $pekerjaan['sup_id'] = $pekerjaan['sup'];
            $pekerjaan['ruas_jalan_id'] = $pekerjaan['ruas_jalan'];
            $pekerjaan['sup'] = DB::table('utils_sup')->where('id',$pekerjaan['sup_id'])->pluck('name')->first();
            $pekerjaan['ruas_jalan'] = DB::table('master_ruas_jalan')->where('id_ruas_jalan',$pekerjaan['ruas_jalan_id'])->pluck('nama_ruas_jalan')->first();

            // dd($pekerjaan);
        }else{
            $temp1=explode(",",$pekerjaan['sup']);
            $temp2=explode(",",$pekerjaan['ruas_jalan']);
            $pekerjaan['sup'] = $temp1[0];
            $pekerjaan['sup_id'] = $temp1[1];
            $pekerjaan['ruas_jalan'] = $temp2[0];
            $pekerjaan['ruas_jalan_id'] = $temp2[1];
        }
        $pekerjaan['nama_mandor'] = $temp[0];
        $pekerjaan['user_id'] = $temp[1];


        // dd($pekerjaan['ruas_jalan']);
        $pekerjaan['created_by'] = Auth::user()->id;

        // $pekerjaan['slug'] = Str::slug($req->nama, '');
        if ($req->foto_awal != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_awal'] = $path;
        }
        if ($req->foto_sedang != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_sedang->getClientOriginalName());
            $req->foto_sedang->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_sedang'] = $path;
        }
        if ($req->foto_akhir != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_akhir->getClientOriginalName());
            $req->foto_akhir->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_akhir'] = $path;
        }
        if ($req->video != null) {
            $path = Str::snake(date("YmdHis") . ' ' . $req->video->getClientOriginalName());
            $req->video->storeAs('public/pekerjaan/', $path);
            $pekerjaan['video'] = $path;
        }
        $row = DB::table('kemandoran')->select('id_pek')->orderByDesc('id_pek')->limit(1)->first();
        if($row){

            $nomor = intval(substr($row->id_pek, strlen('CK-'))) + 1;
        }else
            $nomor = 000001;


        $pekerjaan['tglreal'] = date('Y-m-d H:i:s');
        $pekerjaan['is_deleted'] = 0;

        $pekerjaan['id_pek'] = 'CK-' . str_pad($nomor, 6, "0", STR_PAD_LEFT);

        DB::table('kemandoran')->insert($pekerjaan);

        $color = "success";
        $msg = "Berhasil Menambah Data Pekerjaan";
        return back()->with(compact('color', 'msg'));
    }
    public function updateData(Request $req)
    {
        $pekerjaan = $req->except('_token', 'id_pek');
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        if($pekerjaan['uptd_id'])
            $pekerjaan['uptd_id'] = str_replace('uptd', '', $pekerjaan['uptd_id']);

        if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Mandor')){
            $temp[0]=Auth::user()->name;
            $temp[1]=Auth::user()->id;
        }else
            $temp=explode(",",$pekerjaan['nama_mandor']);

        $temp1=explode(",",$pekerjaan['sup']);
        $temp2=explode(",",$pekerjaan['ruas_jalan']);

        $pekerjaan['nama_mandor'] = $temp[0];
        $pekerjaan['user_id'] = $temp[1];
        $pekerjaan['sup'] = $temp1[0];
        $pekerjaan['sup_id'] = $temp1[1];
        $pekerjaan['ruas_jalan'] = $temp2[0];
        $pekerjaan['ruas_jalan_id'] = $temp2[1];
        // dd($pekerjaan['ruas_jalan']);
        $pekerjaan['updated_by'] = Auth::user()->id;

        $old = DB::table('kemandoran')->where('id_pek', $req->id_pek)->first();
        if ($req->foto_awal != null) {
            $old->foto_awal ?? Storage::delete('public/pekerjaan/' . $old->foto_awal);

            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_awal->getClientOriginalName());
            $req->foto_awal->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_awal'] = $path;
        }
        if ($req->foto_sedang != null) {
            $old->foto_sedang ?? Storage::delete('public/pekerjaan/' . $old->foto_sedang);

            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_sedang->getClientOriginalName());
            $req->foto_sedang->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_sedang'] = $path;
        }
        if ($req->foto_akhir != null) {
            $old->foto_akhir ?? Storage::delete('public/pekerjaan/' . $old->foto_akhir);

            $path = Str::snake(date("YmdHis") . ' ' . $req->foto_akhir->getClientOriginalName());
            $req->foto_akhir->storeAs('public/pekerjaan/', $path);
            $pekerjaan['foto_akhir'] = $path;
        }
        if ($req->video != null) {
            $old->video ?? Storage::delete('public/pekerjaan/' . $old->video);

            $path = Str::snake(date("YmdHis") . ' ' . $req->video->getClientOriginalName());
            $req->video->storeAs('public/pekerjaan/', $path);
            $pekerjaan['video'] = $path;
        }

        DB::table('kemandoran')->where('id_pek', $req->id_pek)->update($pekerjaan);
        $kemandoran =  DB::table('kemandoran');

        $detail_adjustment =  DB::table('kemandoran_detail_status');
        if($detail_adjustment->where('id_pek', $req->id_pek)->where('status', 'Rejected')->where('pointer', 1)->latest('updated_at')->exists()){
            $data['pointer'] = 0;
            $update = DB::table('kemandoran_detail_status')->where('id_pek', $req->id_pek)->update($data);
            if(!$detail_adjustment->where('id_pek', $req->id_pek)->where('adjustment_user_id', Auth::user()->id)->latest('updated_at')->exists()){
                $data['pointer'] = 0;
                $data['adjustment_user_id'] = Auth::user()->id;
                $data['status'] = "Edited";
                $data['id_pek'] = $req->id_pek;
                $data['updated_at'] = Carbon::now();
                $data['created_at'] = Carbon::now();
                $insert = $detail_adjustment->insert($data);
                if($kemandoran->where('id_pek', $req->id_pek)->exists()){
                    $mail['mail'] = 1;
                    // dd($mail);
                    $kemandoran->update($mail);

                }
            }
        }

        $color = "success";
        $msg = "Berhasil Mengubah Data";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }
    public function materialData($id)
    {
        $pekerjaan = DB::table('kemandoran')->where('id_pek', $id)->first();
        // $pekerjaan = $pekerjaan->leftJoin('bahan_material', 'bahan_material.id_pek', '=', 'kemandoran.id_pek')->select('kemandoran.*', 'bahan_material.*');
        $ruas_jalan = DB::table('master_ruas_jalan');
        if (Auth::user()->internalRole->uptd) {
            $ruas_jalan = $ruas_jalan->where('uptd_id', Auth::user()->internalRole->uptd);
        }
        $ruas_jalan = $ruas_jalan->get();

        $sup = DB::table('utils_sup');
        if (Auth::user()->internalRole->uptd) {
            $sup = $sup->where('uptd_id', Auth::user()->internalRole->uptd);
        }

        $jenis = DB::table('item_pekerjaan');
        $jenis = $jenis->get();

        $material1 = DB::table('bahan_material')->where('id_pek', $id)->get();
        if (count($material1) > 0) {
            $material = DB::table('bahan_material')->where('id_pek', $id)->first();
        } else {
            $material = '';
        }

        $bahan = DB::table('item_bahan');
        $bahan = $bahan->get();

        $satuan = DB::table('item_satuan');
        $satuan = $satuan->get();


        $mandor = DB::table('users')->where('user_role.role', 'like', 'mandor%');
        $mandor = $mandor->leftJoin('user_role', 'user_role.id', '=', 'users.internal_role_id')->select('users.*', 'user_role.id as id_role');
        $mandor = $mandor->where('users.id',$pekerjaan->user_id);

        $mandor = $mandor->get();

        $sup = $sup->get();
        $uptd = DB::table('landing_uptd')->get();
        // dd($pekerjaan);
        return view('admin.input.pekerjaan.material', compact('pekerjaan', 'ruas_jalan', 'sup', 'uptd', 'jenis', 'mandor', 'bahan', 'material', 'satuan'));
    }
    public function createDataMaterial(Request $req)
    {
        $pekerjaan = $req->except(['_token']);
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        $pekerjaan['updated_by'] = Auth::user()->id;
        
        DB::table('bahan_material')->insert($pekerjaan);
        $kemandoran =  DB::table('kemandoran');

        if($kemandoran->where('id_pek', $req->id_pek)->where('mail', null)->exists()){
            $mail['mail'] = 1;
            $kemandoran->update($mail);
            $detail_adjustment =  DB::table('kemandoran_detail_status');
            $data['pointer'] = 0;
                $data['adjustment_user_id'] = Auth::user()->id;
                $data['status'] = "Submitted";
                $data['id_pek'] = $req->id_pek;
                $data['updated_at'] = Carbon::now();
                $data['created_at'] = Carbon::now();
                $insert = $detail_adjustment->insert($data);
        }

        $color = "success";
        $msg = "Berhasil Menambah Data Bahan Material";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }


    public function updateDataMaterial(Request $req)
    {
        // dd($req->id_pek);
        $pekerjaan = $req->except('_token', 'id_pek');
        $pekerjaan['uptd_id'] = $req->uptd_id == '' ? 0 : $req->uptd_id;
        $pekerjaan['updated_by'] = Auth::user()->id;

        $kemandoran =  DB::table('kemandoran');

        DB::table('bahan_material')->where('id_pek', $req->id_pek)->update($pekerjaan);

        $detail_adjustment =  DB::table('kemandoran_detail_status');
        if($detail_adjustment->where('id_pek', $req->id_pek)->where('status', 'Rejected')->where('pointer', 1)->latest('updated_at')->exists()){
            $data['pointer'] = 0;
            $update = DB::table('kemandoran_detail_status')->where('id_pek', $req->id_pek)->update($data);
            if(!$detail_adjustment->where('id_pek', $req->id_pek)->where('adjustment_user_id', Auth::user()->id)->latest('updated_at')->exists()){
                $data['pointer'] = 0;
                $data['adjustment_user_id'] = Auth::user()->id;
                $data['status'] = "Edited";
                $data['id_pek'] = $req->id_pek;
                $data['updated_at'] = Carbon::now();
                $data['created_at'] = Carbon::now();
                $insert = $detail_adjustment->insert($data);
                if($kemandoran->where('id_pek', $req->id_pek)->exists()){
                    $mail['mail'] = 1;
                    // dd($mail);
                    $kemandoran->update($mail);

                }
            }
        }
        // dd($kemandoran->where('id_pek', $req->id_pek)->where('mail', null)->exists());
        if($kemandoran->where('id_pek', $req->id_pek)->where('mail', null)->exists()){
            $mail['mail'] = 1;
            // dd($mail);
            $kemandoran->update($mail);

        }


        $color = "success";
        $msg = "Berhasil Mengubah Data Material";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }
    public function show($id)
    {

        $color = "danger";
        $msg = "Something when wrong!";
        $pekerjaan = DB::table('kemandoran')->where('kemandoran.id_pek', $id);
        if(!$pekerjaan->exists())
            return back()->with(compact('color', 'msg'));

        $pekerjaan = $pekerjaan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id_ruas_jalan', '=', 'kemandoran.ruas_jalan_id')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan');
        // $pekerjaan = $pekerjaan->leftJoin('kemandoran_detail_status', 'kemandoran.id_pek', '=','kemandoran_detail_status.id_pek')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan','kemandoran_detail_status.*');
        if (Auth::user() && Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $uptd_id);
            if(str_contains(Auth::user()->internalRole->role,'Mandor')){
                $pekerjaan = $pekerjaan->where('kemandoran.user_id',Auth::user()->id);
            }else if(Auth::user()->sup_id)
                $pekerjaan = $pekerjaan->where('kemandoran.sup_id',Auth::user()->sup_id);
        }

        $pekerjaan = $pekerjaan->whereRaw("YEAR(tanggal) BETWEEN 2021 AND 2021");
        $pekerjaan = $pekerjaan->where('is_deleted', 0)->latest('tglreal')->get();
        foreach($pekerjaan as $no =>$data){
            // echo "$data->id_pek<br>";
            $data->status = "";

            $detail_adjustment=DB::table('kemandoran_detail_status')->where('id_pek',$data->id_pek);
            $input_material= $this->cekMaterial($data->id_pek);
            if($input_material){
                $tempuser= DB::table('users')
                ->leftJoin('user_role','users.internal_role_id','=','user_role.id')->where('users.id',$data->user_id);
                if($tempuser->exists()){
                    $tempuser=$tempuser->first();
                    $data->status = $tempuser;

                    $data->status->status="";
                    // $data->status->status="";

                }
            }
            $data->input_material = $input_material;
            $data->keterangan_status_lap= $detail_adjustment->exists();
            if($detail_adjustment->exists()){

                $detail_adjustment=$detail_adjustment
                ->leftJoin('users','users.id','=','kemandoran_detail_status.adjustment_user_id')
                ->leftJoin('user_role','users.internal_role_id','=','user_role.id');

                if($detail_adjustment->count() > 1){
                    $detail_adjustment=$detail_adjustment->get();
                    foreach($detail_adjustment as $num => $data1){
                        $temp = $data1;
                    }
                    $data->status=$temp;
                    // dd($data);
                }else{
                    $detail_adjustment=$detail_adjustment->first();
                    $data->status=$detail_adjustment;
                }
                $temp=explode(" - ",$data->status->role);
                $data->status->jabatan=$temp[0];
            }

            // echo "$data->id_pek<br>";

        }


        $pekerjaan = $pekerjaan->first();
        // dd($pekerjaan);
        // if($pekerjaan->keterangan_status_lap && $pekerjaan->status->adjustment_user_id != Auth::user()->id){
        //     return back()->with(compact('color', 'msg'));
        // }
        $pekerjaan->email = DB::table('users')->where('id', $pekerjaan->user_id)->pluck('email')->first();

        if(Auth::user()->internalRole->role != null && str_contains(Auth::user()->internalRole->role,'Pengamat'))
            if(Auth::user()->sup_id != $pekerjaan->sup_id){
                return back()->with(compact('color', 'msg'));
                // return redirect('admin/user/profile/'. auth()->user()->id)->with(['error' => 'Somethink when wrong!']);
        }
        $material = DB::table('bahan_material')->where('id_pek', $id)->first();

        // dd($material);
        for($i=1; $i<=15 ;$i++){
            $jum_bahan = "jum_bahan$i";
            $nama_bahan = "nama_bahan$i";
            $satuan = "satuan$i";
            if($material->$jum_bahan != null){
                $pekerjaan->nama_bahan[] = $material->$nama_bahan;
                $pekerjaan->jum_bahan[] = $material->$jum_bahan;
                $pekerjaan->satuan[] = $material->$satuan;

            }
        }
        $detail="";
        $detail = DB::table('kemandoran_detail_status')->where('id_pek', $id);
        if($detail->where('adjustment_user_id',Auth::user()->id)->exists() && $pekerjaan->status->adjustment_user_id == Auth::user()->id){
            $detail = $detail->latest('updated_at')->first();
            $id_pek = $pekerjaan->id_pek;
            $nama_mandor = Str::title($pekerjaan->nama_mandor);
            $jenis_pekerjaan = Str::title($pekerjaan->paket);
            $uptd = Str::upper($pekerjaan->status->uptd);
            $sup_mail = $pekerjaan->sup;
            $status_mail = "di ".$pekerjaan->status->status."<br> oleh ".$pekerjaan->status->name." - ".$pekerjaan->status->role;
            $subject = "Status Laporan ".$pekerjaan->id_pek." - ".$pekerjaan->status->status;
            $pekerjaan->status->next_user = "";

            if(str_contains($pekerjaan->status->status, "Approved")||str_contains($pekerjaan->status->status, "Edited")){
                if(str_contains($pekerjaan->status->jabatan,"Mandor")||str_contains($pekerjaan->status->jabatan,"Pengamat") ){
                    $next_user = DB::table('users')->where('internal_role_id',$pekerjaan->status->parent)->where('sup_id',$pekerjaan->status->sup_id)->get();
                }else{
                    $next_user = DB::table('users')->where('internal_role_id',$pekerjaan->status->parent)->get();

                }

                // dd($next_user);
                $pekerjaan->status->next_user = $next_user;
                // dd($pekerjaan);
                $keterangan_mandor = "Silahkan menunggu sampai semua di terima / Approved";

            // dd($pekerjaan->status->next_user);

            }else if(str_contains($pekerjaan->status->status, "Rejected")){
                $before_user = DB::table('kemandoran_detail_status')->where('kemandoran_detail_status.id_pek', $id)->where('kemandoran_detail_status.adjustment_user_id','!=',$pekerjaan->user_id)->where('kemandoran_detail_status.adjustment_user_id','!=',$pekerjaan->status->adjustment_user_id)->groupBy('adjustment_user_id')
                                ->leftJoin('users', 'users.id', '=', 'kemandoran_detail_status.adjustment_user_id')->get();

                // dd($before_user);

                $pekerjaan->status->next_user = $before_user;
                $keterangan_mandor = "Silahkan ditindak lanjuti";


            }
            // dd($pekerjaan->status->next_user);
            if($pekerjaan->status->next_user != ""){
                foreach($pekerjaan->status->next_user as $no =>$temp){
                    $to_email =$temp->email;
                    $to_name = $temp->name;
                    $keterangan = "Silahkan ditindak lanjuti";

                        $name =Str::title($temp->name);

                    $mail = $this->setSendEmail($name, $id_pek, $nama_mandor, $jenis_pekerjaan, $uptd, $sup_mail, $status_mail, $keterangan, $to_email, $to_name, $subject);

                }
            }
            $name =Str::title($pekerjaan->nama_mandor);
            $to_email =$pekerjaan->email;
            $to_name = $pekerjaan->nama_mandor;
            $mail = $this->setSendEmail($name, $id_pek, $nama_mandor, $jenis_pekerjaan, $uptd, $sup_mail, $status_mail, $keterangan_mandor, $to_email, $to_name, $subject);

        }

        // dd($pekerjaan);
        // dd($pekerjaan);
        return view('admin.input.pekerjaan.show', compact('pekerjaan','material','detail'));
    }
    public function detailPemeliharaan($id)
    {

        $color = "danger";
        $msg = "Something when wrong!";
        $pekerjaan = DB::table('kemandoran')->where('kemandoran.id_pek', $id);
        if(!$pekerjaan->exists())
            return back()->with(compact('color', 'msg'));

        $pekerjaan = $pekerjaan->first();
        $pekerjaan->nama_bahan = [];
        $material = DB::table('bahan_material')->where('id_pek', $id)->first();
        if($material){
            for($i=1; $i<=15 ;$i++){
                $jum_bahan = "jum_bahan$i";
                $nama_bahan = "nama_bahan$i";
                $satuan = "satuan$i";
                if($material->$jum_bahan != null){
                    $pekerjaan->nama_bahan[] = $material->$nama_bahan;
                    $pekerjaan->jum_bahan[] = $material->$jum_bahan;
                    $pekerjaan->satuan[] = $material->$satuan;

                }
            }
        }
        // dd($material);

        // dd($pekerjaan);
        // dd($pekerjaan);
        return view('admin.input.pekerjaan.detail_pekerjaan', compact('pekerjaan','material'));
    }
    public function jugmentLaporan(Request $request, $id){
        // dd($id);
        if(str_contains($request->input('status'),'Rejected')){
            $validator = Validator::make($request->all(), [
                'keterangan' => 'required'
            ]);
            if ($validator->fails()) {
                $color = "danger";
                $msg = "Keterangan Tidak Boleh di Kosongkan!";
                return redirect( route('jugmentDataPekerjaan',$id))->with(compact('color', 'msg'));
            }
            // $this->validate($request,['keterangan' => 'required']);
        }

            $data['status'] = $request->input('status');
            $data['description'] = $request->input('keterangan') ? :null;
            $data['adjustment_user_id'] = Auth::user()->id;
            $kemandoran = DB::table('kemandoran_detail_status');
            if($kemandoran->where('id_pek',$id)->where('adjustment_user_id',Auth::user()->id)->where('pointer',1)->exists()){
                $data['updated_at'] = Carbon::now();
                $kemandoran = $kemandoran->where('id_pek',$id)->latest('updated_at')->update($data);

            }else{

                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();
                $data['id_pek'] = $id;
                $data['pointer'] = 1;
                // dd($data);
                $kemandoran = DB::table('kemandoran_detail_status')->insert($data);
            }
            if($kemandoran){
                //redirect dengan pesan sukses
                $color = "success";
                $msg = "Data Berhasil Diupdate!";
                return redirect(route('jugmentDataPekerjaan', $id))->with(compact('color','msg'));
            }else{
                //redirect dengan pesan error
                $color = "danger";
                $msg = "Data Tidak ada yang Diupdate!";
                return redirect(route('jugmentDataPekerjaan', $id))->with(compact('color', 'msg'));
            }


        // dd($request);
    }
    public function deleteData($id)
    {
        // $temp = DB::table('kemandoran')->where('id',$id)->first();
        $temp = DB::table('bahan_material')->where('id_pek', $id)->delete();
        $param['is_deleted'] = 1;
        $old = DB::table('kemandoran')->where('id_pek', $id)->update($param);

        $color = "success";
        $msg = "Berhasil Menghapus Data Pekerjaan";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }

    public function submitData($id)
    {
        // $temp = DB::table('kemandoran')->where('id',$id)->first();
        $param['rule'] = 'KSUP';
        $pekerjaan = DB::table('kemandoran')->where('id_pek', $id)->update($param);
        $material = DB::table('bahan_material')->where('id_pek', $id)->update($param);

        $color = "success";
        $msg = "Berhasil Melakukan Submit Data Material";
        return redirect(route('getDataPekerjaan'))->with(compact('color', 'msg'));
    }

    public function json(Request $request)
    {
        $pekerjaan = DB::table('kemandoran');

        $pekerjaan = $pekerjaan->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'kemandoran.ruas_jalan')->select('kemandoran.*', 'master_ruas_jalan.nama_ruas_jalan');

        if (Auth::user() && Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $uptd_id);

            if(str_contains(Auth::user()->internalRole->role,'Mandor')){
                $pekerjaan = $pekerjaan->where('kemandoran.user_id',Auth::user()->id);
            }else if(Auth::user()->sup_id)
                $pekerjaan = $pekerjaan->where('kemandoran.sup_id',Auth::user()->sup_id);
        }
        $from = $request->year_from;
        $to = $request->year_to;
        $pekerjaan = $pekerjaan->whereRaw("YEAR(tanggal) BETWEEN $from AND $to");
        $pekerjaan = $pekerjaan->where('is_deleted', 0)->get();

        return DataTables::of($pekerjaan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';

                if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Update")) {
                    $btn = $btn . '<a href="' . route('editDataPekerjaan', $row->id_pek) . '"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-sm waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                    $btn = $btn . '<a href="' . route('materialDataPekerjaan', $row->id_pek) . '"><button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="tooltip" title="Material"><i class="icofont icofont-list"></i></button></a>';
                }

                if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Delete")) {
                    $btn = $btn . '<a href="#delModal" data-id="' . $row->id_pek . '" data-toggle="modal"><button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="tooltip" title="Hapus"><i class="icofont icofont-trash"></i></button></a>';
                }

                if (hasAccess(Auth::user()->internal_role_id, "Pekerjaan", "Update")) {
                    $btn = $btn . '<a href="#submitModal" data-id="' . $row->id_pek . '" data-toggle="modal"><button class="btn btn-success btn-sm waves-effect waves-light" data-toggle="tooltip" title="Submit"><i class="icofont icofont-check-circled"></i></button></a>';
                }

                $btn = $btn . '</div>';

                // $btn = '<a href="javascript:void(0)" class="btn btn-primary">' . $row->id . '</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
