<?php

namespace App\Filament\Resources\SuratKelahiranResource\Pages;

use App\Filament\Resources\SuratKelahiranResource;
use App\Models\Pejabat;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\SuratKelahiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EditSuratKelahiran extends EditRecord
{
    protected static string $resource = SuratKelahiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $record = $this->record;
                    return $this->export($record);
                }),
        ];
    }

    public function export(SuratKelahiran $record)
    {

        $bayi = $record->bayi;
        $ibu = $record->ibu;
        $ayah = $record->ayah;
        $pelapor = $record->pelapor;
        $saksi1 = $record->saksiSatu;
        $saksi2 = $record->saksiDua;
        $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();

        $umur_ibu = $ibu ? Carbon::parse($ibu->tanggal_lahir)->age : '';
        $umur_ayah = $ayah ? Carbon::parse($ayah->tanggal_lahir)->age : '';
        $umur_pelapor = $pelapor ? Carbon::parse($pelapor->tanggal_lahir)->age : '';
        $umur_saksi1 = $saksi1 ? Carbon::parse($saksi1->tanggal_lahir)->age : '';
        $umur_saksi2 = $saksi2 ? Carbon::parse($saksi2->tanggal_lahir)->age : '';

        $data = [
            // Data Surat
            'kode_wilayah' => $record->kode_wilayah,
            'nomor_surat' => $record->nomor_surat,
            'nama_kepala_keluarga' => $record->nama_kepala_keluarga,
            'nomor_kepala_keluarga' => $record->nomor_kepala_keluarga,
            // Bayi
            'nama_bayi' => $bayi->nama ?? '',
            'jenis_kelamin_bayi' => $bayi->jenis_kelamin ?? '',
            'tempat_dilahirkan' => $bayi->tempat_dilahirkan ?? '',
            'tempat_kelahiran' => $bayi->tempat_kelahiran ?? '',
            'tanggal_lahir_bayi' => Carbon::parse($bayi->tanggal_lahir)->format('Y-m-d') ?? '',
            'pukul_lahir' => $bayi->pukul_lahir ?? '',
            'jenis_kelahiran' => $bayi->jenis_kelahiran ?? '',
            'kelahiran_ke' => $bayi->kelahiran_ke ?? '',
            'penolong_kelahiran' => $bayi->penolong_kelahiran ?? '',
            'berat_bayi' => $bayi->berat_bayi ?? '',
            'panjang_bayi' => $bayi->panjang_bayi ?? '',
            // Ibu
            'nik_ibu' => $ibu->nik ?? '',
            'nama_ibu' => $ibu->nama ?? '',
            'tanggal_lahir_ibu' => Carbon::parse($ibu->tanggal_lahir)->format('Y-m-d') ?? '',
            'umur_ibu' => $umur_ibu,
            'pekerjaan_ibu' => $ibu->pekerjaan ?? '',
            'alamat_ibu' => $ibu->alamat ?? '',
            'desa_kelurahan_ibu' => $ibu->{"desa-kelurahan"} ?? '',
            'kabupaten_kota_ibu' => $ibu->kabupaten ?? '',
            'kecamatan_ibu' => $ibu->kecamatan ?? '',
            'provinsi_ibu' => $ibu->provinsi ?? '',
            'kewarganegaraan_ibu' => $ibu->kewarganegaraan ?? '',
            'kebangsaan_ibu' => $ibu->kebangsaan ?? '',
            'tgl_kawin' => $ibu->tanggal_pencatatan_perkawinan ?? '',
            // Ayah
            'nik_ayah' => $ayah->nik ?? '',
            'nama_ayah' => $ayah->nama ?? '',
            'tanggal_lahir_ayah' => Carbon::parse($ayah->tanggal_lahir)->format('Y-m-d') ?? '',
            'umur_ayah' => $umur_ayah,
            'pekerjaan_ayah' => $ayah->pekerjaan ?? '',
            'alamat_ayah' => $ayah->alamat ?? '',
            'desa_kelurahan_ayah' => $ayah->{"desa-kelurahan"} ?? '',
            'kabupaten_kota_ayah' => $ayah->kabupaten ?? '',
            'kecamatan_ayah' => $ayah->kecamatan ?? '',
            'provinsi_ayah' => $ayah->provinsi ?? '',
            'kewarganegaraan_ayah' => $ayah->kewarganegaraan ?? '',
            'kebangsaan_ayah' => $ayah->kebangsaan ?? '',
            // Pelapor
            'nik_pelapor' => $pelapor->nik ?? '',
            'nama_pelapor' => $pelapor->nama ?? '',
            'umur_pelapor' => $umur_pelapor,
            'jenis_kelamin_pelapor' => $pelapor->jenis_kelamin ?? '',
            'pekerjaan_pelapor' => $pelapor->pekerjaan ?? '',
            'alamat_pelapor' => $pelapor->alamat ?? '',
            'desa_kelurahan_pelapor' => $pelapor->{"desa-kelurahan"} ?? '',
            'kabupaten_kota_pelapor' => $pelapor->kabupaten ?? '',
            'kecamatan_pelapor' => $pelapor->kecamatan ?? '',
            'provinsi_pelapor' => $pelapor->provinsi ?? '',
            // Saksi 1
            'nik_saksi1' => $saksi1->nik ?? '',
            'nama_saksi1' => $saksi1->nama ?? '',
            'umur_saksi1' => $umur_saksi1,
            'pekerjaan_saksi1' => $saksi1->pekerjaan ?? '',
            'alamat_saksi1' => $saksi1->alamat ?? '',
            'desa_kelurahan_saksi1' => $saksi1->{"desa-kelurahan"} ?? '',
            'kabupaten_kota_saksi1' => $saksi1->kabupaten ?? '',
            'kecamatan_saksi1' => $saksi1->kecamatan ?? '',
            'provinsi_saksi1' => $saksi1->provinsi ?? '',
            // Saksi 2
            'nik_saksi2' => $saksi2->nik ?? '',
            'nama_saksi2' => $saksi2->nama ?? '',
            'umur_saksi2' => $umur_saksi2,
            'pekerjaan_saksi2' => $saksi2->pekerjaan ?? '',
            'alamat_saksi2' => $saksi2->alamat ?? '',
            'desa_kelurahan_saksi2' => $saksi2->{"desa-kelurahan"} ?? '',
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
            echo Pdf::loadView('surat.kelahiran', $data)->output();
        }, 'surat-kelahiran-' . $record->nama_kepala_keluarga . '.pdf');
        
        
    }
    
    
}
