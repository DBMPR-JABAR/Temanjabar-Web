<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailKerusakanJalanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "nomorPengaduan" => $this->nomorPengaduan,
            "namaPelapor" => $this->nama,
            "nikPelapor" => $this->nik,
            "nomorHpPelapor" => $this->telp,
            "emailPelapor" => $this->email,
            "uptd" => $this->uptd->nama,
            "kategori_laporan" => $this->jenis,
            "latitude" => $this->lat,
            "longitude" => $this->long,
            "foto_kondisi" => $this->gambar
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
