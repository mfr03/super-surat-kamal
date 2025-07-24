<?php

namespace App\Exports;

use App\Models\SuratKeteranganUsaha;
use App\Models\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SuratKeteranganUsahaExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
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
            'Nama Pemohon',
            'Nama Usaha',
            'Selama',
            'Tujuan Surat',
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nomor Surat
            'B' => NumberFormat::FORMAT_TEXT, // Nama Pemohon
            'C' => NumberFormat::FORMAT_TEXT, // Nama Usaha
            'D' => NumberFormat::FORMAT_TEXT, // Selama
            'E' => NumberFormat::FORMAT_TEXT, // Tujuan Surat
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Dibuat
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nomor Surat
            'B' => 30, // Nama Pemohon
            'C' => 25, // Nama Usaha
            'D' => 15, // Selama
            'E' => 20, // Tujuan Surat
            'F' => 18, // Tanggal Dibuat
        ];
    }


    public function collection()
    {
        return SuratKeteranganUsaha::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get([
                'nomor_surat',
                'warga_id',
                'nama_usaha',
                'selama',
                'tujuan_surat',
                'created_at'
            ])->map(function ($item) {

                $warga = Warga::find($item->warga_id);

                return [
                    'Nomor Surat' => $item->nomor_surat,
                    'Nama Pemohon' => $warga?->nama,
                    'Nama Usaha' => $item->nama_usaha,
                    'Selama' => $item->selama,
                    'Tujuan Surat' => $item->tujuan_surat,
                    'Tanggal Dibuat' => Date::dateTimeToExcel($item->created_at),
                ];
            });
    }
}
