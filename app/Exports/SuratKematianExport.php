<?php

namespace App\Exports;

use App\Models\Jenazah;
use App\Models\SuratKematian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SuratKematianExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected int $month;
    protected int $year;
    public function __construct(int $month, int $year) 
    {
        $this->month = $month;
        $this->year = $year;
    }




    public function collection()
    {
        return SuratKematian::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get([
                'nomor_surat',
                'nama_kepala_keluarga',
                'nomor_kepala_keluarga',
                'nama_jenazah',
                'tanggal_kematian',
                'created_at'
            ])->map(function ($item) {
                $jenazah = Jenazah::find($item->jenazah_id);
                return [
                    'Nomor Surat' => $item->nomor_surat,
                    'Nama Kepala Keluarga' => $item->nama_kepala_keluarga,
                    'Nomor Kepala Keluarga' => $item->nomor_kepala_keluarga,
                    'Nama Jenazah' => $jenazah ? $jenazah->nama : 'Tidak Diketahui',
                    'Tanggal Kematian' => $jenazah ? Date::dateTimeToExcel($jenazah->tanggal_kematian) : 'Tidak Diketahui',
                    'Tanggal Dibuat' => Date::dateTimeToExcel($item->created_at),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Nama Kepala Keluarga',
            'Nomor Kepala Keluarga',
            'Nama Jenazah',
            'Tanggal Kematian',
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nomor Surat
            'B' => NumberFormat::FORMAT_TEXT, // Nama Kepala Keluarga
            'C' => NumberFormat::FORMAT_NUMBER, // Nomor Kepala Keluarga
            'D' => NumberFormat::FORMAT_TEXT, // Nama Jenazah
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Kematian
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Dibuat
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nomor Surat
            'B' => 30, // Nama Kepala Keluarga
            'C' => 20, // Nomor Kepala Keluarga
            'D' => 30, // Nama Jenazah
            'E' => 15, // Tanggal Kematian
            'F' => 15, // Tanggal Dibuat
        ];
    }
}
