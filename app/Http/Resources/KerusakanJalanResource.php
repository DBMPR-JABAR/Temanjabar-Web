<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KerusakanJalanResource extends JsonResource
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
            "id" => $this->id,
            "latitude" => 0+$this->lat,
            "longitude" => 0+$this->long,
            "keterangan" => $this->jenis
        ];
    }
    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
