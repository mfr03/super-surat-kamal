<?php

namespace App\Exports;

use App\Models\SuratPengantar;
use App\Models\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SuratPengantarExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
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
            'Keperluan',
            'Tujuan',
            'Berlaku Mulai',
            'Keterangan',
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Nomor Surat
            'B' => NumberFormat::FORMAT_TEXT, // Jabatan TTD
            'C' => NumberFormat::FORMAT_TEXT, // Nama Warga
            'D' => NumberFormat::FORMAT_TEXT, // Keperluan
            'E' => NumberFormat::FORMAT_TEXT, // Tujuan
            'F' => NumberFormat::FORMAT_TEXT, // Berlaku Mulai
            'G' => NumberFormat::FORMAT_TEXT, // Keterangan
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Tanggal Dibuat
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 30,
            'D' => 25,
            'E' => 25,
            'F' => 20,
            'G' => 30,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SuratPengantar::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get([
                'nomor_surat',
                'jabatan_ttd',
                'warga_id',
                'keperluan',
                'tujuan',
                'berlaku_mulai',
                'keterangan',
                'created_at'
            ])->map(function ($item) {
                $warga = Warga::find($item->warga_id);
                return [
                    'Nomor Surat' => $item->nomor_surat,
                    'Jabatan TTD' => $item->jabatan_ttd,
                    'Nama Warga' => $warga->nama ?? '',
                    'Keperluan' => $item->keperluan,
                    'Tujuan' => $item->tujuan,
                    'Berlaku Mulai' => $item->berlaku_mulai,
                    'Keterangan' => $item->keterangan,
                    'Tanggal Dibuat' => \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel($item->created_at),
                ];
            });
    }
}
