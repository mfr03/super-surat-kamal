<?php

namespace App\Exports;

use App\Models\Jenazah;
use App\Models\Warga;
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
                'jenazah_id',
            ])->map(function ($item) {
                $jenazah = Jenazah::find($item->jenazah_id);
                $warga = Warga::find($jenazah->warga_id);
                return [
                    'Nama' => $warga ? $warga->nama : 'Tidak Diketahui',
                    'NIK' => $warga ? $warga->nik : 'Tidak Diketahui',
                    'Umur' => $warga ? $warga->tanggal_lahir->diffInYears(now()) : 'Tidak Diketahui',
                    'Tanggal Kematian' => $jenazah ? Date::dateTimeToExcel($jenazah->tanggal_kematian) : 'Tidak Diketahui',
                    'Alamat' => $warga ? $warga->alamat : 'Tidak Diketahui',
                    'Keterangan' => $jenazah->sebab_kematian ?? 'Tidak Diketahui',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Umur',
            'Tanggal Kematian',
            'Alamat',
            'Keterangan',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nama
            'B' => NumberFormat::FORMAT_NUMBER, // NIK
            'C' => NumberFormat::FORMAT_TEXT, // Umur
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Kematian
            'E' => NumberFormat::FORMAT_TEXT, // Alamat
            'F' => NumberFormat::FORMAT_TEXT, // Keterangan
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, // Nama || NIK
            'B' => 25, // NIK
            'C' => 15, // Umur
            'D' => 20, // Tanggal Kematian
            'E' => 30, // Alamat
            'F' => 30, // Keterangan

        ];
    }
}
