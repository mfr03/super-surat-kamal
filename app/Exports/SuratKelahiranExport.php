<?php

namespace App\Exports;

use App\Models\SuratKelahiran;
use App\Models\Bayi;
use App\Models\Warga;
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
                'ibu_id',
                'ayah_id',
                'bayi_id',
                'nomor_kepala_keluarga',
                'created_at',
            ])->map(function ($item) {
                $ibu = Warga::find($item->ibu_id);
                $bapak = Warga::find($item->ayah_id);
                $bayi = Bayi::find($item->bayi_id);
                return [
                    'Tanggal dibuat' => Date::dateTimeToExcel($item->created_at),
                    'Nama Bapak dan Ibu' => $bapak->nama . ' - ' . $ibu->nama,
                    'Nama Anak' => $bayi->nama,
                    'NIK Kepala Keluarga' => Date::dateTimeToExcel($item->created_at),
                    'Tanggal Percatatan Perkawinan' => $ibu->tanggal_pencatatan_perkawinan ? Date::dateTimeToExcel($ibu->tanggal_pencatatan_perkawinan) : '',
                    'Tanggal Kelahiran' => Date::dateTimeToExcel($bayi->tanggal_lahir),
                    'Keterangan Penolong' => $bayi->penolong_kelahiran,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal dibuat',
            'Nama Bapak dan Ibu',
            'Nama Anak',
            'NIK Kepala Keluarga',
            'Tanggal Percatatan Perkawinan',
            'Tanggal Kelahiran',
            'Keterangan Penolong',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nomor Surat
            'B' => 30, // Nama Kepala Keluarga
            'C' => 20, // Nomor Kepala Keluarga
            'D' => 18, // Tanggal Dibuat
            'E' => 20, // Nomor Surat
            'F' => 30, // Nama Kepala Keluarga
            'G' => 20, // Nomor Kepala Keluarga
        ];
    }
}
