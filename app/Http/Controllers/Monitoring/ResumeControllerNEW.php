<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResumeController extends Controller
{
    public function pekerjaan(Request $request)
    {
        $pekerjaan = DB::table('kemandoran');

        $pekerjaan = $pekerjaan
        ->leftJoin('utils_jenis_laporan','utils_jenis_laporan.id', 'kemandoran.jenis_pekerjaan')
            ->leftJoin('master_ruas_jalan', 'master_ruas_jalan.id', '=', 'kemandoran.ruas_jalan')
            ->select([
                'kemandoran.id_pek',
                'kemandoran.nama_mandor',
                'kemandoran.sup',
                'kemandoran.ruas_jalan',
                'kemandoran.paket',
                'kemandoran.lokasi',
                'kemandoran.uptd_id',
                'kemandoran.sup_id',
                'kemandoran.panjang',
                'kemandoran.user_id',
                'kemandoran.is_deleted',
                'kemandoran.perkiraan_kuantitas',
                'kemandoran.tanggal',
                'master_ruas_jalan.nama_ruas_jalan',
                'utils_jenis_laporan.name as jenis_pekerjaan',
            ]);

        if (Auth::user() && Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $uptd_id);
            if (str_contains(Auth::user()->internalRole->role, 'Mandor')) {
                $pekerjaan = $pekerjaan->where('kemandoran.user_id', Auth::user()->id);
            } else if (Auth::user()->sup_id) {
                $pekerjaan = $pekerjaan->where('kemandoran.sup_id', Auth::user()->sup_id);
            }

        }

        $now = Carbon::now()->toDateString();

        $filter = null;
        if ($request->filter) {
            $filter = (object) [
                "tanggal_awal" => $request->tanggal_awal,
                "tanggal_akhir" => $request->tanggal_akhir,
                "uptd" => $request->uptd,
                "sup" => $request->sup,
            ];
            $pekerjaan = $pekerjaan->whereRaw("tanggal BETWEEN '" . $request->tanggal_awal . "' AND '" . $request->tanggal_akhir . "'");
            $pekerjaan = $pekerjaan->where('kemandoran.uptd_id', $request->uptd);
            if ($request->sup != 'ALL') {
                $pekerjaan = $pekerjaan->where('kemandoran.sup_id', $request->sup);
            }

        } else {
            $pekerjaan = $pekerjaan->whereRaw("tanggal BETWEEN '" . $now . "' AND '" . $now . "'");
        }
        $pekerjaan = $pekerjaan->where('is_deleted', 0)->latest('tglreal')->get();

        foreach ($pekerjaan as $no => $data) {
            $data->status = "";
            $detail_adjustment = DB::table('kemandoran_detail_status')->where('id_pek', $data->id_pek);

            $input_material = $this->cekMaterial($data->id_pek);
            if ($input_material) {
                $tempuser = DB::table('users')
                    ->leftJoin('user_role', 'users.internal_role_id', '=', 'user_role.id')->where('users.id', $data->user_id);
                if ($tempuser->exists()) {
                    $tempuser = $tempuser->first();
                    $data->status = $tempuser;
                    $data->status->status = "";
                }
            }

            if ($detail_adjustment->exists()) {
                if ($detail_adjustment->count() > 1) {
                    $data->status = $detail_adjustment->OrderBy('kemandoran_detail_status.created_at', 'desc')->first();
                } else {
                    $data->status = $detail_adjustment->first();
                }
            }
        }

        $uptd = DB::table('landing_uptd');
        $sup = DB::table('utils_sup');
        if (Auth::user() && Auth::user()->internalRole->uptd) {
            $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
            $uptd = $uptd->where('id', $uptd_id);
            $sup = $sup->where('uptd_id', $uptd_id);
        }
        $uptd = $uptd->get();
        $sup = $sup->get();


        return view('admin.monitoring.pekerjaan.resume', compact('filter', 'uptd', 'pekerjaan', 'sup'));
    }

    public static function cekMaterial($id)
    {
        $cek = DB::table('bahan_material')->where('id_pek', $id)->exists();
        return $cek;
    }
}
