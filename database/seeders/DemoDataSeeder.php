<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bayi;
use App\Models\Warga;
use App\Models\Jenazah;
use App\Models\KodeSurat;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
use App\Models\SuratKelahiran;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create KodeSurat records
        $kodeSurats = [
            ['kode' => 'SKL', 'detail' => 'Surat Kelahiran'],
            ['kode' => 'SKM', 'detail' => 'Surat Kematian'],
            ['kode' => 'SKU', 'detail' => 'Surat Keterangan Usaha'],
            ['kode' => 'SPI', 'detail' => 'Surat Pengantar Izin Perjamuan'],
            ['kode' => 'SKP', 'detail' => 'Surat Pengantar Keterangan'],
        ];

        $pejabat = [
            ['jabatan' => 'Kepala Desa', 'nama' => 'Widodo', 'alamat' => 'Ngosong 2/3, Ds.Kamal, Kec. Bulu, Kab. Sukoharjo'],
            ['jabatan' => 'Sekretaris Desa', 'nama' => 'Suwandi', 'alamat' => 'Ngosong 2/4, Ds.Kamal, Kec. Bulu, Kab. Sukoharjo'],
            ['jabatan' => 'Kaur TU', 'nama' => 'Subandi', 'alamat' => 'Ngosong 2/5, Ds.Kamal, Kec. Bulu, Kab. Sukoharjo'],
        ];

        foreach ($pejabat as $data) {
            \App\Models\Pejabat::create($data);
        }

        foreach ($kodeSurats as $data) {
            KodeSurat::create($data);
        }

        $faker = Faker::create('id_ID');

        // --- WARGA ---
        for ($i = 0; $i < 20; $i++) {
            Warga::create([
                'nik' => $faker->unique()->numerify('################'),
                'nama' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tanggal_lahir' => $faker->date('Y-m-d', '-18 years'),
                'tempat_lahir' => $faker->city,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan' => $faker->jobTitle,
                'alamat' => $faker->address,
                'nomor_hp' => $faker->phoneNumber,
                'kartu_keluarga' => $faker->numerify('################'),
                'desa-kelurahan' => $faker->citySuffix,
                'kecamatan' => $faker->city,
                'kabupaten' => $faker->city,
                'provinsi' => $faker->state,
                'kewarganegaraan' => $faker->randomElement(['WNI', 'WNA']),
                'kebangsaan' => 'Indonesia',
                'tanggal_pencatatan_perkawinan' => $faker->optional()->date('Y-m-d', '-1 years'),
            ]);
        }

        // --- BAYI ---
        for ($i = 0; $i < 20; $i++) {
            Bayi::create([
                'nama' => $faker->firstName . ' ' . $faker->lastName,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_dilahirkan' => $faker->randomElement(['Rumah Sakit', 'Puskesmas', 'Rumah Bersalin', 'Rumah']),
                'tempat_kelahiran' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', 'now'),
                'pukul_lahir' => $faker->time('H:i'),
                'jenis_kelahiran' => $faker->randomElement(['Tunggal', 'Kembar 2', 'Kembar 3']),
                'kelahiran_ke' => $faker->numberBetween(1, 5),
                'penolong_kelahiran' => $faker->randomElement(['Bidan', 'Dokter', 'Dukun', 'Lainnya']),
                'berat_bayi' => $faker->randomFloat(2, 2.0, 5.0),
                'panjang_bayi' => $faker->randomFloat(1, 45, 60),
            ]);
        }

        $wargaIds = Warga::pluck('id')->toArray();

        for ($i = 0; $i < 5; $i++) {
            Jenazah::create([
                'warga_id' => $faker->randomElement($wargaIds),
                'anak_ke' => $faker->numberBetween(1, 5),
                'tanggal_kematian' => $faker->date('Y-m-d', 'now'),
                'pukul_kematian' => $faker->time('H:i'),
                'sebab_kematian' => $faker->randomElement(['Sakit', 'Kecelakaan', 'Tua', 'Lainnya']),
                'tempat_kematian' => $faker->city,
                'yang_menerangkan' => $faker->randomElement(['Dokter', 'Bidan', 'Kepala Desa', 'Lainnya']),
            ]);


        $wargas = Warga::pluck('id')->toArray();
        $bayis = Bayi::pluck('id')->toArray();

            for ($i = 0; $i < 10; $i++) {
                SuratKelahiran::create([
                    'kode_wilayah' => $faker->postcode,
                    'nomor_surat' => 'SKL/' . Str::upper(Str::random(3)) . '/' . ($i+1) . '/' . date('Y'),
                    'jabatan_ttd' => $faker->randomElement(['Kepala Desa', 'Sekretaris Desa', 'Kaur TU']),
                    'nama_kepala_keluarga' => $faker->name,
                    'nomor_kepala_keluarga' => $faker->numerify('###############'),
                    'bayi_id' => $faker->randomElement($bayis),
                    'ibu_id' => $faker->randomElement($wargas),
                    'ayah_id' => $faker->randomElement($wargas),
                    'pelapor_id' => $faker->randomElement($wargas),
                    'saksi_satu_id' => $faker->randomElement($wargas),
                    'saksi_dua_id' => $faker->randomElement($wargas),
                ]);
            }
        } 
    }
}
