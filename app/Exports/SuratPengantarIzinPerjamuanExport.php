<?php

namespace App\Exports;

use App\Models\SuratPengantarIzinPerjamuan;
use App\Models\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;    

class SuratPengantarIzinPerjamuanExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
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

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Nama Pemohon',
            'Tanggal Perjamuan',
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nomor Surat
            'B' => NumberFormat::FORMAT_TEXT, // Nama Pemohon
            'C' => NumberFormat::FORMAT_TEXT, // Tanggal Perjamuan
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Dibuat
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Nomor Surat
            'B' => 30, // Nama Pemohon
            'C' => 20, // Tanggal Perjamuan
            'D' => 20, // Tanggal Dibuat
        ];
    }

    public function collection()
    {
        return SuratPengantarIzinPerjamuan::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get([
                'nomor_surat',
                'warga_id',
                'keperluan',
                'hari-tanggal',
                'created_at'
            ])->map(function ($item) {
                $warga = Warga::find($item->warga_id);
                return [
                    'Nomor Surat' => $item->nomor_surat,
                    'Nama Pemohon' => $warga ? $warga->nama : ' ',
                    'Tanggal Perjamuan' => $item->{'hari-tanggal'},
                    'Tanggal Dibuat' => Date::dateTimeToExcel($item->created_at),
                ];
            });
    }
}
