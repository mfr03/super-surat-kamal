<?php

namespace App\Exports;

use App\Models\SuratKelahiran;
use App\Models\SuratKeteranganUsaha;
use App\Models\SuratKematian;
use App\Models\SuratPengantar;
use App\Models\SuratPengantarIzinPerjamuan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class AllSuratExport implements FromCollection , WithHeadings, WithColumnFormatting, WithColumnWidths
{
    protected int $month;
    protected int $year;

    public function __construct(int $month, int $year) 
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nomor Surat
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Dibuat
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nomor Surat
            'B' => 20, // Tanggal Dibuat
        ];
    }

public function collection()
{
    $allSurat = [];

    $allSurat = array_merge($allSurat, SuratKelahiran::whereMonth('created_at', $this->month)
        ->whereYear('created_at', $this->year)
        ->get(['nomor_surat', 'created_at'])
        ->map(fn($item) => [
            $item->nomor_surat,
            Date::dateTimeToExcel($item->created_at),
        ])
        ->all()
    );

    $allSurat = array_merge($allSurat, SuratKematian::whereMonth('created_at', $this->month)
        ->whereYear('created_at', $this->year)
        ->get(['nomor_surat', 'created_at'])
        ->map(fn($item) => [
            $item->nomor_surat,
            Date::dateTimeToExcel($item->created_at),
        ])
        ->all()
    );

    $allSurat = array_merge($allSurat, SuratKeteranganUsaha::whereMonth('created_at', $this->month)
        ->whereYear('created_at', $this->year)
        ->get(['nomor_surat', 'created_at'])
        ->map(fn($item) => [
            $item->nomor_surat,
            Date::dateTimeToExcel($item->created_at),
        ])
        ->all()
    );

    $allSurat = array_merge($allSurat, SuratPengantar::whereMonth('created_at', $this->month)
        ->whereYear('created_at', $this->year)
        ->get(['nomor_surat', 'created_at'])
        ->map(fn($item) => [
            $item->nomor_surat,
            Date::dateTimeToExcel($item->created_at),
        ])
        ->all()
    );

    $allSurat = array_merge($allSurat, SuratPengantarIzinPerjamuan::whereMonth('created_at', $this->month)
        ->whereYear('created_at', $this->year)
        ->get(['nomor_surat', 'created_at'])
        ->map(fn($item) => [
            $item->nomor_surat,
            Date::dateTimeToExcel($item->created_at),
        ])
        ->all()
    );

    return collect($allSurat);
}

}
