<?php

namespace App\Exports;

use App\Exports\PekerjaanDistanceExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PekerjaanDistanceMultipleSheetExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $uptd = DB::table('kemandoran_with_distance')->select('uptd_id')->OrderBy('uptd_id')->distinct()->get();
        // dd($uptd);

        foreach ($uptd as $key => $value) {
            $sheets[] = new PekerjaanDistanceExport($value->uptd_id);
        }

        return $sheets;
    }
}
