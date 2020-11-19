<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgressLaporanResource extends JsonResource
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
            'idPetugas' => $this->idPetugas,
            'petugas' => $this->petugas,
            'perkembangan' => $this->perkembangan,
            'persentase' => $this->persentase,
            'dokumentasi' => $this->dokumentasi
        ];
    }
    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
