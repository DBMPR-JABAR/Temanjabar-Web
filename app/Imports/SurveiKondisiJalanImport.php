<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use phpDocumentor\Reflection\Types\Boolean;
use PHPUnit\Framework\Constraint\Count;

class SurveiKondisiJalanImport implements ToCollection
{

    private $idRuasJalan,$isDeleted;

    public function __construct(string $idRuasJalan, string $isDeleted)
    {
        $this->idRuasJalan = $idRuasJalan;
        $this->isDeleted = $isDeleted;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $totalSpeed = 0;
        $averageSpeed = 0;
        $count = 0;
        foreach ($collection as $row) {
            if ($count != 0) {
                $totalSpeed = $totalSpeed + $row[2];
            }
            $count = $count + 1;
        };
        $averageSpeed = $totalSpeed / $count;
        $masterRuasJalan = DB::table('master_ruas_jalan')->where('id_ruas_jalan', $this->idRuasJalan)->first();
        $tempLat = (float)$masterRuasJalan->lat_awal;
        $tempLong = (float)$masterRuasJalan->long_awal;
        $isFirst = 0;
        $distance = 0;
        foreach ($collection as $row) {
            if ($isFirst != 0) {
                $segmentExt = getDistanceBetweenLatLong($tempLat, $tempLong, $row[0], $row[1]);
                $tempLat = $row[0];
                $tempLong = $row[1];
                $formatedDistance = number_format((float)$segmentExt, 2, '.', '');
                $distance = $distance + $formatedDistance;
                $tempSegment = number_format((float)$distance / 100, 2, '.', '');
                $formatedSegment = str_pad($tempSegment, 6, 0, STR_PAD_LEFT);
                $surveiKondisiJalan = [
                    'id_ruas_jalan' => $this->idRuasJalan,
                    'id_segmen' => $this->idRuasJalan . $formatedSegment,
                    'latitude' => $row[0],
                    'longitude' => $row[1],
                    'distance' => $distance,
                    'speed' => $row[2],
                    'avg_speed' => $averageSpeed,
                    'altitude' => $row[3],
                    'altitude_10' => $row[3] / 10,
                    'e_iri' => $row[4],
                    'c_iri' => $row[5],
                    'created_user' => Auth::user()->id,
                ];

                $skjTable = DB::table('roadroid_trx_survey_kondisi_jalan')->where([
                    ['id_ruas_jalan' ,'=', $this->idRuasJalan],
                    ['latitude', '=', $row[0]],
                    ['longitude', '=', $row[1]],
                ]);
                if($this->isDeleted == "Y")
                    $skjTable->delete();
                else if(Count($skjTable->get()))
                    $skjTable->update($surveiKondisiJalan);
                else
                    $skjTable->insert($surveiKondisiJalan);
            }
            $isFirst = $isFirst + 1;
        }
    }
}
