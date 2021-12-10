<?php

namespace App\Exports;

use DateTime;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PekerjaanDistancePercentaseExport implements FromCollection,
WithStyles,
WithHeadings,
WithMapping,
WithTitle,
ShouldAutoSize
{

    public function __construct($uptd_id)
    {
        $this->uptd_id = $uptd_id;
    }

    public function collection()
    {

        $report = DB::table('kemandoran_with_distance')
            ->select(DB::raw('count(id_pek) as total'),
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('YEAR(tanggal) as year'),
                DB::raw('COUNT(CASE WHEN distance <= 100 THEN 1 END) as on_track'),
                DB::raw('COUNT(CASE WHEN distance > 100 AND distance <=200 THEN 1 END) as on_track_end'),
                DB::raw('COUNT(CASE WHEN distance >200 THEN 1 END) as out_track'),
                DB::raw('CONCAT_WS("-",MONTH(tanggal),YEAR(tanggal)) as monthyear'))
            ->where('uptd_id', $this->uptd_id)
            ->OrderBy('year')
            ->OrderBy('month')
            ->groupby('monthyear')
            ->get();
        return $report;
    }

    public function monthName($month)
    {
        $dateObj = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        return $monthName;
    }

    public function headings(): array
    {
        $headings = ['BULAN', '0 - 100M', '100 - 200M', '>200M', '0 - 100M (%)', '100 - 200M (%)', '>200M (%)', 'TOTAL'];
        return $headings;
    }

    public function map($data): array
    {
        return [
            $this->monthName($data->month) . ' ' . $data->year,
            $data->on_track,
            $data->on_track_end,
            $data->out_track,
            number_format(($data->on_track / $data->total) * 100, 2).'%',
            number_format(($data->on_track_end / $data->total) * 100, 2).'%',
            number_format(($data->out_track / $data->total) * 100, 2).'%',
            $data->total,
        ];
    }

    public function title(): string
    {
        return 'Report UPTD ' . $this->uptd_id;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            '1' => ['font' => ['bold' => true, 'color' => ['rgb' => '000000']]],
        ];
    }
}
