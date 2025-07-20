<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bayi;
use App\Models\Warga;
use App\Models\Jenazah;
use App\Models\KodeSurat;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create KodeSurat records
        $kodeSurats = [
            ['kode' => 'SKL', 'detail' => 'Surat Kelahiran'],
            ['kode' => 'SKM', 'detail' => 'Surat Kematian'],
            ['kode' => 'SKU', 'detail' => 'Surat Keterangan Usaha'],
        ];

        foreach ($kodeSurats as $data) {
            KodeSurat::create($data);
        }

        // Create Warga records
        $warga = Warga::create([
            'nik' => '1234567890123456',
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-05-12',
            'tempat_lahir' => 'Jakarta',
            'agama' => 'Islam',
            'pekerjaan' => 'Petani',
            'alamat' => 'Jl. Merdeka No. 1',
            'kartu_keluarga' => '1111222233334444',
            'desa-kelurahan' => 'Kelurahan Sukamaju',
            'kecamatan' => 'Kecamatan Sukabumi',
            'kabupaten' => 'Kabupaten Sukabumi',
            'provinsi' => 'Jawa Barat',
            'kewarganegaraan' => 'Indonesia',
            'kebangsaan' => 'Indonesia',
            'tanggal_pencatatan_perkawinan' => '2015-08-17',
        ]);

        // Create Bayi records
        Bayi::create([
            'nama' => 'Ani Setiawati',
            'jenis_kelamin' => 'Perempuan',
            'tempat_dilahirkan' => 'Rumah Sakit',
            'tempat_kelahiran' => 'Bandung',
            'tanggal_lahir' => Carbon::now()->subDays(30),
            'pukul_lahir' => '07:30',
            'jenis_kelahiran' => 'Tunggal',
            'kelahiran_ke' => 1,
            'penolong_kelahiran' => 'Bidan',
            'berat_bayi' => 3.2,
            'panjang_bayi' => 49.5
        ]);

        // Create Jenazah record for the same warga
        Jenazah::create([
            'warga_id' => $warga->id,
            'anak_ke' => 2,
            'tanggal_kematian' => Carbon::now()->subDays(5),
            'pukul_kematian' => '14:00',
            'sebab_kematian' => 'Sakit',
            'tempat_kematian' => 'Rumah',
            'yang_menerangkan' => 'Dokter'
        ]);
    }
}
