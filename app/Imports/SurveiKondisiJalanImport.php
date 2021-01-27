<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class SurveiKondisiJalanImport implements ToCollection
{

    private $idRuasJalan;

    public function __construct(int $idRuasJalan)
    {
        $this->idRuasJalan = $idRuasJalan;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $totalSpeed = 0;
        $averageSpeed = 0;
        $count = 0;
        foreach($collection as $row) {
            $totalSpeed = $totalSpeed + $row[4];
            $count++;
        };
        $averageSpeed = $totalSpeed/$count;

        foreach($collection as $row) {
            $surveiKondisiJalan = [
                'id_ruas_jalan' => $this->idRuasJalan,
                'id_segmen' => $row[0],
                'latitude' => $row[1],
                'longitude' => $row[2],
                'distance'=> $row[3],
                'speed' => $row[4],
                'avg_speed' =>$averageSpeed,
                'altitude'=> $row[5],
                'altitude_10' => $row[5]/10,
                'e_iri'=>$row[6],
                'c_iri'=>$row[7],
                'created_user'=> Auth::user()->id,
            ];

            DB::table('roadroid_trx_survey_kondisi_jalan')->insert($surveiKondisiJalan);
        }
    }
}
