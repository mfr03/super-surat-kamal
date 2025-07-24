<?php

namespace App\Exports;

use App\Models\SuratKelahiran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SuratKelahiranExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
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
        return SuratKelahiran::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get([
                'nomor_surat',
                'nama_kepala_keluarga',
                'nomor_kepala_keluarga',
                'created_at'
            ])->map(function ($item) {

                return [
                    'Nomor Surat' => $item->nomor_surat,
                    'Nama Kepala Keluarga' => $item->nama_kepala_keluarga,
                    'Nomor Kepala Keluarga' => $item->nomor_kepala_keluarga,
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
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nomor Surat
            'B' => NumberFormat::FORMAT_TEXT, // Nama Kepala Keluarga
            'C' => NumberFormat::FORMAT_NUMBER, // Nomor Kepala Keluarga
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nomor Surat
            'B' => 30, // Nama Kepala Keluarga
            'C' => 20, // Nomor Kepala Keluarga
            'D' => 18, // Tanggal Dibuat
        ];
    }
}
