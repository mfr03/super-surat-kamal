<?php

namespace App\Filament\Resources\SuratKeteranganUsahaResource\Pages;

use App\Filament\Resources\SuratKeteranganUsahaResource;
use App\Models\Pejabat;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\SuratKeteranganUsaha;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Warga;


class EditSuratKeteranganUsaha extends EditRecord
{
    protected static string $resource = SuratKeteranganUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action((function () {
                    $record = $this->record;
                    return $this->export($record);
            })),
        ];
    }

    public function export(SuratKeteranganUsaha $record)
    {
        $pemohon = $record->warga; 
        $ibu = Warga::find($record->ibu_id); 
        $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();
        $data = [
            'nomor' => $record->nomor_surat ?? '',
            'nama_pejabat' => $pejabat->nama ?? '',
            'jabatan' => $record->jabatan_ttd ?? '',
            'nama' => $pemohon->nama ?? '',
            'nik' => $pemohon->nik ?? '',
            'jenis_kelamin' => $pemohon->jenis_kelamin ?? '',
            'agama' => $pemohon->agama ?? '',
            'ibu_kandung' => $ibu->nama ?? '',
            'nomor_hp' => $pemohon->nomor_hp ?? '',
            'domisili' => $pemohon->alamat ?? '',
            'nama_usaha' => $record->nama_usaha ?? '',
            'selama' => $record->selama ?? '',
            'alasan' => $record->tujuan_surat ?? '',
            'tanggal' => now()->translatedFormat('j F Y'),
        ];

        // Sanitize all string values
        $data = array_map(function ($value) {
            if (is_string($value)) {
                $value = str_replace("\0", '', $value);
                $value = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $value);
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
            return $value;
        }, $data);

        return response()->streamDownload(function () use ($data) {
            echo Pdf::loadView('surat.keterangan-usaha', $data)->output();
        }, 'surat-keterangan-usaha-' . ($pemohon->nama ?? 'pemohon') . '.pdf');
    }
}
