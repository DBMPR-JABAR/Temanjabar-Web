<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusLaporanResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data["nomorPengaduan"] = $this->nomorPengaduan;
        if($this->status == "On Progress") $data['deskripsi'] = $this->deskripsi;

        return $data;
    }
    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
