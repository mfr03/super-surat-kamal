<?php

namespace App\Filament\Resources\SuratPengantarIzinPerjamuanResource\Pages;

use App\Filament\Resources\SuratPengantarIzinPerjamuanResource;
use App\Models\SuratPengantarIzinPerjamuan;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Pejabat;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class EditSuratPengantarIzinPerjamuan extends EditRecord
{
    protected static string $resource = SuratPengantarIzinPerjamuanResource::class;

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

    public function export(SuratPengantarIzinPerjamuan $record) {
        $pemohon = $record->warga;
        $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();
        $data = [
            'nomor' => $record->nomor_surat ?? '',
            'nama_pemohon' => $pemohon->nama ?? '',
            'nama_pejabat' => $pejabat->nama ?? '',
            'jabatan' => $record->jabatan_ttd ?? '',
            'nama' => $pemohon->nama ?? '',
            'jenis_kelamin' => $pemohon->jenis_kelamin ?? '',
            'agama' => $pemohon->agama ?? '',
            'nik' => $pemohon->nik ?? '',
            'tempat_tanggal_lahir' => $pemohon->tempat_lahir . ', ' . Carbon::parse($pemohon->tanggal_lahir)->format('Y-m-d') ?? '',
            'pekerjaan' => $pemohon->pekerjaan ?? '',
            'alamat' => $pemohon->alamat ?? '',
            'keperluan' => $record->keperluan ?? '',
            'undangan' => $record->undangan ?? '',
            'jenis_pertunjukan' => $record->jenis_pertunjukan ?? '',
            'hari_tanggal' => $record->{'hari-tanggal'} ?? '',
            'tanggal' => Carbon::parse(Carbon::now())->locale('id')->translatedFormat('d F Y'), 
            'berlaku_mulai_tanggal' => $record->berlaku_mulai ?? '',
            'keterangan_lain' => $record->keterangan_lain_lain ?? '',
        ];

        $data = array_map(function ($value) {
            if (is_string($value)) {
                $value = str_replace("\0", '', $value);
                $value = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $value);
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
            return $value;
        }, $data);

        return response()->streamDownload(function () use ($data) {
            echo Pdf::loadView('surat.pengantar-izin-perjamuan', $data)->output();
        }, 'surat-pengantar-izin-perjamuan-' . ($pemohon->nama ?? 'pemohon') . '.pdf');

    }

}
