<?php

namespace App\Filament\Resources\SuratKematianResource\Pages;

use App\Filament\Resources\SuratKematianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\SuratKematian;
use App\Models\Pejabat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class EditSuratKematian extends EditRecord
{
    protected static string $resource = SuratKematianResource::class;

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

    public function export(SuratKematian $record)
    {
        $jenazah = $record->jenazah;
        $warga = $jenazah ? $jenazah->warga : null;
        $ibu = $record->ibu;
        $ayah = $record->ayah;
        $pelapor = $record->pelapor;
        $saksi1 = $record->saksiSatu;
        $saksi2 = $record->saksiDua;
        $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();

        $umur_jenazah = $warga && $warga->tanggal_lahir
            ? Carbon::parse($warga->tanggal_lahir)->age
            : '';
        $umur_pelapor = $pelapor && $pelapor->tanggal_lahir
            ? Carbon::parse($pelapor->tanggal_lahir)->age
            : '';
        $umur_saksi1 = $saksi1 && $saksi1->tanggal_lahir
            ? Carbon::parse($saksi1->tanggal_lahir)->age
            : '';
        $umur_saksi2 = $saksi2 && $saksi2->tanggal_lahir
            ? Carbon::parse($saksi2->tanggal_lahir)->age
            : '';

        $data = [
            // Surat & Kepala Keluarga
            'kode_wilayah' => $record->kode_wilayah,
            'nomor_surat' => $record->nomor_surat,
            'nama_kepala_keluarga' => $record->nama_kepala_keluarga,
            'nomor_kepala_keluarga' => $record->nomor_kepala_keluarga,
            // Jenazah
            'nama_jenazah' => $warga->nama ?? '',
            'jenis_kelamin' => $warga->jenis_kelamin ?? '',
            'tanggal_lahir_jenazah' => $warga->tanggal_lahir ? Carbon::parse($jenazah->tanggal_lahir)->format('d-m-Y') : '',
            'umur_jenazah' => $umur_jenazah,
            'tempat_kelahiran' => $warga->tempat_lahir ?? '',
            'agama' => $warga->agama ?? '',
            'pekerjaan' => $warga->pekerjaan ?? '',
            'alamat_jenazah' => $warga->alamat ?? '',
            'desa_kelurahan_jenazah' => $warga->{'desa-kelurahan'} ?? '',
            'kabupaten_kota_jenazah' => $warga->kabupaten ?? '',
            'kecamatan_jenazah' => $warga->kecamatan ?? '',
            'provinsi_jenazah' => $warga->provinsi ?? '',
            'anak_ke' => $jenazah->anak_ke ?? '',
            'tanggal_kematian_jenazah' => $jenazah->tanggal_kematian ? Carbon::parse($jenazah->tanggal_kematian)->format('d-m-Y') : '',
            'pukul' => $jenazah->pukul_kematian ?? '',
            'sebab_kematian' => $jenazah->sebab_kematian ?? '',
            'tempat_kematian' => $jenazah->tempat_kematian ?? '',
            'yang_menerangkan' => $jenazah->yang_menerangkan ?? '',
            // Ibu
            'nik_ibu' => $ibu->nik ?? '',
            'nama_ibu' => $ibu->nama ?? '',
            'pekerjaan_ibu' => $ibu->pekerjaan ?? '',
            'alamat_ibu' => $ibu->alamat ?? '',
            'tanggal_lahir_umur_ibu' => $ibu->tanggal_lahir ? Carbon::parse($ibu->tanggal_lahir)->format('d-m-Y') . ' / ' . Carbon::parse($ibu->tanggal_lahir)->age . ' Tahun' : '',
            'desa_kelurahan_ibu' => $ibu->{'desa-kelurahan'} ?? '',
            'kabupaten_kota_ibu' => $ibu->kabupaten ?? '',
            'kecamatan_ibu' => $ibu->kecamatan ?? '',
            'provinsi_ibu' => $ibu->provinsi ?? '',
            // Ayah
            'nik_ayah' => $ayah->nik ?? '',
            'nama_ayah' => $ayah->nama ?? '',
            'pekerjaan_ayah' => $ayah->pekerjaan ?? '',
            'alamat_ayah' => $ayah->alamat ?? '',
            'tanggal_lahir_umur_ayah' => $ayah->tanggal_lahir ? Carbon::parse($ayah->tanggal_lahir)->format('d-m-Y') . ' / ' . Carbon::parse($ayah->tanggal_lahir)->age . ' Tahun' : '',
            'desa_kelurahan_ayah' => $ayah->{'desa-kelurahan'} ?? '',
            'kabupaten_kota_ayah' => $ayah->kabupaten ?? '',
            'kecamatan_ayah' => $ayah->kecamatan ?? '',
            'provinsi_ayah' => $ayah->provinsi ?? '',
            // Pelapor
            'nik_pelapor' => $pelapor->nik ?? '',
            'nama_pelapor' => $pelapor->nama ?? '',
            'umur_pelapor' => $umur_pelapor,
            'jenis_kelamin_pelapor' => $pelapor->jenis_kelamin ?? '',
            'pekerjaan_pelapor' => $pelapor->pekerjaan ?? '',
            'alamat_pelapor' => $pelapor->alamat ?? '',
            'desa_kelurahan_pelapor' => $pelapor->{'desa-kelurahan'} ?? '',
            'kabupaten_kota_pelapor' => $pelapor->kabupaten ?? '',
            'kecamatan_pelapor' => $pelapor->kecamatan ?? '',
            'provinsi_pelapor' => $pelapor->provinsi ?? '',
            // Saksi 1
            'nik_saksi1' => $saksi1->nik ?? '',
            'nama_saksi1' => $saksi1->nama ?? '',
            'umur_saksi1' => $umur_saksi1,
            'pekerjaan_saksi1' => $saksi1->pekerjaan ?? '',
            'alamat_saksi1' => $saksi1->alamat ?? '',
            'desa_kelurahan_saksi1' => $saksi1->{'desa-kelurahan'} ?? '',
            'kabupaten_kota_saksi1' => $saksi1->kabupaten ?? '',
            'kecamatan_saksi1' => $saksi1->kecamatan ?? '',
            'provinsi_saksi1' => $saksi1->provinsi ?? '',
            // Saksi 2
            'nik_saksi2' => $saksi2->nik ?? '',
            'nama_saksi2' => $saksi2->nama ?? '',
            'umur_saksi2' => $umur_saksi2,
            'pekerjaan_saksi2' => $saksi2->pekerjaan ?? '',
            'alamat_saksi2' => $saksi2->alamat ?? '',
            'desa_kelurahan_saksi2' => $saksi2->{'desa-kelurahan'} ?? '',
            'kabupaten_kota_saksi2' => $saksi2->kabupaten ?? '',
            'kecamatan_saksi2' => $saksi2->kecamatan ?? '',
            'provinsi_saksi2' => $saksi2->provinsi ?? '',
            // Pejabat & Tanggal
            'jabatan' => $record->jabatan_ttd,
            'nama_pejabat' => $pejabat->nama ?? '',
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
            echo Pdf::loadView('surat.kematian', $data)->output();
        }, 'surat-kematian-' . ($jenazah->nama ?? 'jenazah') . '.pdf');
    }



}
