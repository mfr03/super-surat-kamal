<?php

namespace App\Filament\Resources\SuratPengantarResource\Pages;

use App\Filament\Resources\SuratPengantarResource;
use App\Models\Pejabat;
use App\Models\SuratPengantar;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class EditSuratPengantar extends EditRecord
{
    protected static string $resource = SuratPengantarResource::class;

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

    public function export(SuratPengantar $record)
    {
        $pemohon = $record->warga;
        $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();
        $data = [
            'nomor' => $record->nomor_surat ?? '',
            'nama' => $pemohon->nama ?? '',
            'tempat_tanggal_lahir' => ($pemohon->tempat_lahir ?? '') . ', ' . (
                $pemohon->tanggal_lahir
                    ? Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y')
                    : ''
            ),
            'kewarganegaraan' => $pemohon->kewarganegaraan ?? 'Indonesia',
            'agama' => $pemohon->agama ?? '',
            'pekerjaan' => $pemohon->pekerjaan ?? '',
            'tempat_tinggal' => $pemohon->alamat ?? '',
            'nik' => $pemohon->nik ?? '',
            'kk' => $pemohon->kartu_keluarga ?? '',
            'keperluan' => $record->keperluan ?? '',
            'berlaku_mulai' => $record->berlaku_mulai ?? '',
            'berlaku_sampai' => $record->berlaku_sampai ?? '',
            'keterangan_lain' => $record->keterangan ?? '',
            'tanggal' => now()->translatedFormat('j F Y'),
            'jabatan' => $record->jabatan_ttd ?? '',
            'nama_pejabat' => $pejabat->nama ?? '',
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
            echo Pdf::loadView('surat.pengantar', $data)->output();
        }, 'surat-pengantar-' . $pemohon->nama . '.pdf');
        
    }
}
