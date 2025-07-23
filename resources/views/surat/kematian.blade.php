<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Kematian</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8px;
            background-color: #ffffff;
        }

        @page {
            size: 8.5in 11in;
            margin: 0.5in;
        }

        table {
            width: 100%;
            border-collapse: collapse;
           
        }

        .tabel-kiri,
        .tabel-kiri td {
            border: none;

        }

        .tabel-kiri {
            width: 100%;
        }

        .kiri-data {
            width: 20%;
        }

        .titik-dua {
            width: 2px;
        }

        .kanan-data {
            width: 80%;
            text-align: left;
            padding: 0px 0;
        }
        .alamat {
            width: 20%;
            text-align: left;
            padding: 0px 0;
        }
        .alamat-data {
            width: 30%;
            text-align: left;
            padding: 0px;
        }

        .tabel-kanan {
            border: none;
        }

        td,
        th {
            text-align: left;
        }

        .tabel-data {
            border: 2px solid black;
            border-bottom: 0px;
        }

        .end {
            border-bottom: 2px solid black;
        }

        .header-table,
        .header-table td {
            border: none;
        }

        .section-title {
            font-weight: bolder;
            text-align: left;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .header-kiri{
            width: 20%;
            text-align: left;
        }
        .header-ket{
            width: 20%;
            text-align: right;

        }
        .header-desa{
            width: 40%;

        }
        .header-lembar{
            width: 8%;
            
        }
        .header-data{
            width: 20%;
            text-align: left;

        }
        .kodeku{
            width: 15%;
            border: 1px solid black;
            text-align: center;
        }

        .warna{
            width: 90%;
        }
    </style>
</head>

<body onload="">


    <div>
        <table>
          
            <tr>
                <td class="warna"></td>
                <td class="kodeku">
                    <h2 style="margin: 3px;">
                    Kode . F-2.01
                    </h2>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div>
        <table>
            <tr>
                <td class="header-kiri">Pemerintah Desa/Kelurahan</td>
                <td class="titik-dua"> : </td>
                <td class="header-desa"> Kamal </td>
                <td class="header-ket"> Ket</td>
                <td class="titik-dua"> :</td>
                <td class="header-lembar"> Lembar 1</td>
                <td class="titik-dua"> : </td>
                <td class="header-data"> UPTD/Instansi Pelaksana</td>

            </tr>
            <tr>
                <td>Kecamatan</td>
                <td class="titik-dua"> : </td>
                <td>Bulu </td>
                <td > </td>
                <td> </td>
                
                <td> Lembar 2</td>
                <td> : </td>
                <td> Untuk yang bersangkutan</td>
            </tr>
            <tr>
                <td>Kabupaten/Kota</td>
                <td class="titik-dua"> : </td>
                <td>Sukoharjo</td>
                <td > </td>


                <td> </td>
                <td> Lembar 3</td>
                <td> : </td>
                <td> Desa/Kelurahan</td>

            </tr>
            <tr>
                <td></td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> Lembar 4</td>
                <td> : </td>
                <td> Kecamatan</td>
            </tr>
            <tr>
                <td>Kode Wilayah</td>
                <td> : </td>
                <td> {{ $kode_wilayah }} </td>

                
            </tr>
           
        </table>
    </div>

    <h1 style="text-align: center; margin:0px;">SURAT KETERANGAN KEMATIAN</h1>
    <h3 style="text-align: center; margin:0px;">Nomor : {{ $nomor_surat }}</h3>



    <table class="">
        <tr>

            <td class="kiri-data">Nama Kepala Keluarga</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_kepala_keluarga }}</td>
        </tr>
        <tr>
            <td class="kiri-data">Nomor Kepala Keluarga</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nomor_kepala_keluarga }}</td>
        </tr>

    </table>

    <!-- Table for jenazah / ANAK -->
    <table class="tabel-data">
        <tr>
            <th colspan="3" class="section-title">JENAZAH</th>
        </tr>
        <tr>
            <td class="kiri-data">1. Nama</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_jenazah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">2. Jenis Kelamin</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $jenis_kelamin }}</td>
        </tr>
        <tr>
            <td class="kiri-data">3. Hari dan Tanggal Lahir</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $tanggal_lahir_jenazah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">4. Umur</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $umur_jenazah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">5. Tempat Lahir </td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $tempat_kelahiran }}</td>
        </tr>
        <tr>
            <td class="kiri-data">6. Agama </td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $agama }}</td>
        </tr>
        <tr>
            <td class="kiri-data">7. Pekerjaan </td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $pekerjaan }}</td>
        </tr>
        <tr>
            <td class="kiri-data">8. Alamat</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $alamat_jenazah }}</td>
        </tr>
        <tr>
            <td class="kiri-data"></td>
            <td class="titik-dua"></td>
            <td class="kanan-data">
                <table>
                    <tr>
                        <td class="alamat">a. Desa/Kelurahan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $desa_kelurahan_jenazah }} </td>
                        <td class="alamat">b. Kabupaten/Kota</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kabupaten_kota_jenazah }}</td>
                    </tr>
                    <tr>
                        <td class="alamat">c. Kecamatan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kecamatan_jenazah }}</td>
                        <td class="alamat">d. Provinsi</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $provinsi_jenazah }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="kiri-data">9. Anak ke </td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $anak_ke }}</td>
        </tr>
        <tr>
            <td class="kiri-data">10. Tanggal Kematian </td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $tanggal_kematian_jenazah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">11. Pukul</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{$pukul}} </td>
        </tr>
        <tr>
            <td class="kiri-data">12. Sebab Kematian</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{$sebab_kematian}} </td>
        </tr>
        <tr>
            <td class="kiri-data">13. Tempat Kematian</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{$tempat_kematian}} </td>
        </tr>
        <tr>
            <td class="kiri-data">14. Yang Menerangkan</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{$yang_menerangkan}} </td>
        </tr>
        
    </table>


        
        <!-- Table for IBU -->
    <table class="tabel-data">
        <tr>
            <th colspan="3" class="section-title">IBU</th>
        </tr>
        <tr>
            <td class="kiri-data">1. NIK</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nik_ibu }}</td>
        </tr>
        <tr>
            <td class="kiri-data">2. Nama Lengkap</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_ibu }}</td>
        </tr>
        <tr>
            <td class="kiri-data">3. Tanggal Lahir / Umur</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $tanggal_lahir_umur_ibu }}</td>
        </tr>
        <tr>
            <td class="kiri-data">4. Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $pekerjaan_ibu }}</td>
        </tr>
        <tr>
            <td class="kiri-data">5. Alamat</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $alamat_ibu }}</td>
        </tr>
        <tr>
            <td class="kiri-data"></td>
            <td class="titik-dua"></td>
            <td class="kanan-data">
                <table>
                    <tr>
                        <td class="alamat">a. Desa/Kelurahan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $desa_kelurahan_ibu }} </td>
                        <td class="alamat">b. Kabupaten/Kota</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kabupaten_kota_ibu }}</td>
                    </tr>
                    <tr>
                        <td class="alamat">c. Kecamatan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kecamatan_ibu }}</td>
                        <td class="alamat">d. Provinsi</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $provinsi_ibu }}</td>
                    </tr>
                </table>
            </td>
        </tr>
      
    </table>

    <!-- Table for AYAH -->
    <table class="tabel-data">
        <tr>
            <th colspan="3" class="section-title">AYAH</th>
        </tr>
        <tr>
            <td class="kiri-data">1. NIK</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nik_ayah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">2. Nama Lengkap</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_ayah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">3. Tanggal Lahir / Umur</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data"> {{ $tanggal_lahir_umur_ayah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">4. Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $pekerjaan_ayah }}</td>
        </tr>
        <tr>
            <td class="kiri-data">5. Alamat</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $alamat_ayah }}</td>
        </tr>
        <tr>
            <td class="kiri-data"></td>
            <td class="titik-dua"></td>
            <td class="kanan-data">
                <table>
                    <tr>
                        <td class="alamat">a. Desa/Kelurahan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $desa_kelurahan_ayah }}</td>
                        <td class="alamat">b. Kabupaten/Kota</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kabupaten_kota_ayah }}</td>
                    </tr>
                    <tr>
                        <td class="alamat">c. Kecamatan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kecamatan_ayah }}</td>
                        <td class="alamat">d. Provinsi</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $provinsi_ayah }}</td>
                    </tr>
                </table>
            </td>
        </tr>
       
    </table>

    <!-- Table for PELAPOR -->
    <table class="tabel-data">
        <tr>
            <th colspan="3" class="section-title">PELAPOR</th>
        </tr>
        <tr>
            <td class="kiri-data">1. NIK</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nik_pelapor }}</td>
        </tr>
        <tr>
            <td class="kiri-data">2. Nama Lengkap</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_pelapor }}</td>
        </tr>
        <tr>
            <td class="kiri-data">3. Umur</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $umur_pelapor }} Tahun</td>
        </tr>
        <tr>
            <td class="kiri-data">4. Jenis Kelamin</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $jenis_kelamin_pelapor }}</td>
        </tr>
        <tr>
            <td class="kiri-data">5. Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $pekerjaan_pelapor }}</td>
        </tr>
        <tr>
            <td class="kiri-data">6. Alamat</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $alamat_pelapor }}</td>
        </tr>
        <tr>
            <td class="kiri-data"></td>
            <td class="titik-dua"></td>
            <td class="kanan-data">
                <table>
                    <tr>
                        <td class="alamat">a. Desa/Kelurahan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $desa_kelurahan_pelapor }}</td>
                        <td class="alamat">b. Kabupaten/Kota</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kabupaten_kota_pelapor }}</td>
                    </tr>
                    <tr>
                        <td class="alamat">c. Kecamatan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kecamatan_pelapor }}</td>
                        <td class="alamat">d. Provinsi</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $provinsi_pelapor }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Table for SAKSI I -->
    <table class="tabel-data">
        <tr>
            <th colspan="3" class="section-title">SAKSI I</th>
        </tr>
        <tr>
            <td class="kiri-data">1. NIK</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nik_saksi1 }}</td>
        </tr>
        <tr>
            <td class="kiri-data">2. Nama Lengkap</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_saksi1 }}</td>
        </tr>
        <tr>
            <td class="kiri-data">3. Umur</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $umur_saksi1 }} Tahun</td>
        </tr>
        <tr>
            <td class="kiri-data">4. Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $pekerjaan_saksi1 }}</td>
        </tr>
        <tr>
            <td class="kiri-data">5. Alamat</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $alamat_saksi1 }}</td>
        </tr>
        <tr>
            <td class="kiri-data"></td>
            <td class="titik-dua"></td>
            <td class="kanan-data">
                <table>
                    <tr>
                        <td class="alamat">a. Desa/Kelurahan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $desa_kelurahan_saksi1 }}</td>
                        <td class="alamat">b. Kabupaten/Kota</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kabupaten_kota_saksi1 }}</td>
                    </tr>
                    <tr>
                        <td class="alamat">c. Kecamatan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kecamatan_saksi1 }}</td>
                        <td class="alamat">d. Provinsi</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $provinsi_saksi1 }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Table for SAKSI II -->
    <table class="tabel-data end">
        <tr>
            <th colspan="3" class="section-title">SAKSI II</th>
        </tr>
        <tr>
            <td class="kiri-data">1. NIK</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nik_saksi2 }}</td>
        </tr>
        <tr>
            <td class="kiri-data">2. Nama Lengkap</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $nama_saksi2 }}</td>
        </tr>
        <tr>
            <td class="kiri-data">3. Umur</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $umur_saksi2 }} Tahun</td>
        </tr>
        <tr>
            <td class="kiri-data">4. Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $pekerjaan_saksi2 }}</td>
        </tr>
        <tr>
            <td class="kiri-data">5. Alamat</td>
            <td class="titik-dua">:</td>
            <td class="kanan-data">{{ $alamat_saksi2 }}</td>
        </tr>
        <tr>
            <td class="kiri-data"></td>
            <td class="titik-dua"></td>
            <td class="kanan-data">
                <table>
                    <tr>
                        <td class="alamat">a. Desa/Kelurahan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $desa_kelurahan_saksi2 }}</td>
                        <td class="alamat">b. Kabupaten/Kota</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kabupaten_kota_saksi2 }}</td>
                    </tr>
                    <tr>
                        <td class="alamat">c. Kecamatan</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $kecamatan_saksi2 }}</td>
                        <td class="alamat">d. Provinsi</td>
                        <td class="tiik-dua">:</td>
                        <td class="alamat-data">{{ $provinsi_saksi2 }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width:100%;  table-layout:fixed; margin: 0px; margin-top: 5px; ">
        <tr>
            <td style="width:15%; text-align:center;">
                <div class="tanda_tangan">
                    <div class="kosong" id="pejabat">
                        <p style="margin: 0px;">Mengetahui,</p>
                        @if($jabatan == 'kepala_desa' || $jabatan == 'KEPALA_DESA')
                        <p style="margin: 0px;">Kepala Desa Kamal</p>

                        @elseif($jabatan == 'sekdes' || $jabatan == 'SEKDES')
                        <p style="margin: 0px;">a/n Kepala Desa Kamal</p>
                        <p style="margin: 0px;">Sekretaris Desa</p>

                        @elseif($jabatan == 'kaur_tu' || $jabatan == 'KAUR_TU')
                        <p style="margin: 0px;">a/n Kepala Desa Kamal</p>
                        <p style="margin: 0px;">KAUR TU</p>
                        @endif
                    </div>
                    <div id="nama_pejabat">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <span style="text-transform:uppercase;">
                            {{ $nama_pejabat }}
                        </span>
                    </div>

                </div>
            </td>
            <td style="width:70%; text-align:left;">
              {{-- kosong --}}
            </td>

            <td style="width:15%; text-align:center;">
                <div class="tanda_tangan" id="ybs">
                    <div>Kamal, {{ $tanggal }} </div>
                    <div class="kosong">Pelapor</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div id="nama_pemohon" style="text-transform:uppercase;">{{ $nama_pelapor }}</div>
                </div>
            </td>
            

        </tr>

       
    </table>

    

</body>

</html>