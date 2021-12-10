<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PekerjaanDistanceExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{

    public function __construct($uptd_id)
    {
        $this->uptd_id = $uptd_id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $resume = DB::table('kemandoran_with_distance')
        ->where('uptd_id', $this->uptd_id)
        ->OrderBy('distance')
        ->get();
        return $resume;
    }

    public function headings(): array
    {
        return [
            'Kode Laporan',
            'Nama Mandor',
            'Latitude',
            'Longitude',
            'Jarak',
            'Tanggal Kalkulasi',
            'Tanggal Pekerjaan',
            'Aksi',
        ];
    }

    public function map($data): array
    {
        $distance = $data->distance;
        return [
            $data->id_pek,
            ucwords(strtolower($data->nama_mandor)),
            $data->lat,
            $data->lng,
            $distance,
            // $distance > 1000 ? number_format($distance / 1000, 2) . ' KM' : number_format($distance, 2) . ' M',
            Carbon::parse($data->calculate_time)->format('d F Y H:i:s'),
            $data->tanggal,
            '=HYPERLINK("' . 'https://sp.temanjabar.net/admin/input-data/pekerjaan/edit/' . $data->id_pek . '", "edit")',
        ];
    }

    public function title(): string
    {
        return 'UPTD ' . $this->uptd_id;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'H' => ['font' => ['italic' => true, 'color' => ['rgb' => '0000FF']]],
            '1' => ['font' => ['bold' => true, 'color' => ['rgb' => '000000']]],
        ];
    }
}
