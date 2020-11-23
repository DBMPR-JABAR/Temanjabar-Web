<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KemantapanJalanResource extends JsonResource
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
            "id" => $this->ID_KEMANTAPAN,
            "latitude" => $this->LAT_AWAL,
            "longitude" => $this->LONG_AWAL
        ];
    }
    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
