<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan</title>
    
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
        }
        /* .rangkasurat {
            width: 980px;
            margin: 0 auto;
            background-color: #fff;
            height: 500px;
            padding: 20px;
        } */
        .headerAtas {
            
            border-bottom: 5px solid #000;
            padding: 2px;
            width: 100%;
        }
        .tengah {
            text-align: center;
            line-height: 5px;
            padding-right: 100px;
        }
        .row{
            margin-top: 20px
        }
        .lampiran{
            margin-top: 20px;
        }
        .atasbawah{
            margin: 0px;
        }

        .suratbold {
            font-weight: bold;
            text-decoration: underline;
            font-size: larger;
            padding-right: 0px;
        }
        
    </style>
</head>
<body onload="window.print()">
    <div class="rangkasurat">
        <table class="headerAtas">
            <tr>
                <td><img src="./sukoharjo.jpg" width="80px"></td>
                <td class="tengah">
                    <h2>PEMERINTAH KABUPATEN SUKOHARJO</h2>
                    <h2>KECAMATAN BULU</h2>
                    <h2>DESA KAMAL</h2>
                    <p >Alamat: Jl. Raya Bulu - Sanggang Km 2.5 No. Telp, Kode Pos 57563</p>
                    <p></p>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="tengah suratbold">
        <p>SURAT PENGANTAR IZIN PERJAMUAN</p>
    </div>
    <div class="tengah" style="padding-right: 0px">
        <p>Nomor: {{ $nomor }}</p>
    </div>
    <div class="content">
        
        <p>Yang bertanda tangan dibawah ini, saya:</p>

        <table style="width:100%; border-collapse:collapse; table-layout:fixed; margin: 0px;">
            <tr>
                <td style="width:20%; text-align:left; ">Nama</td>
                <td style="width:10%; text-align:center;">:</td>
                <td style="width:60%;">
                    <p class="atasbawah">{{ $nama_pejabat }}</p>
                </td>
            </tr>
           
            <tr>
                <td style="text-align:left;"> Jabatan</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah" style="text-transform:uppercase;">{{ $jabatan }}</p>
                </td>
            </tr>

            <tr>
                <td style="text-align:left;"> Alamat</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah" style="text-transform:uppercase;">{{ $alamat }}</p>
                </td>
            </tr>
            
        </table>
        
                <p>
                    Dengan ini menerangkan bahwa :
                </p>
            
        <table style="width:100%; border-collapse:collapse; table-layout:fixed; margin: 0px;">

            <tr>
                <td style="width: 20%; text-align:left; ">Nama</td>
                <td style="width: 10%; text-align:center;">:</td>
                <td style="width: 60%;">
                    <p class="atasbawah">{{ $nama }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Jenis Kelamin</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $jenis_kelamin }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Agama</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $agama }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">NIK</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $nik }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">TTL</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $tempat_tanggal_lahir }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Pekerjaan/Jabatan</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $pekerjaan}}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Alamat</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $alamat }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Keperluan</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $keperluan }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Undangan</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $undangan }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Jenis Pertunjukkan</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $jenis_pertunjukan }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Hari / Tanggal</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $hari_tanggal }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Berlaku Mulai Tanggal</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $berlaku_mulai_tanggal }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; vertical-align: top;">Keterangan Lain - Lain</td>
                <td style="text-align:center; vertical-align: top;">:</td>
                <td style="text-align:justify; word-wrap: break-word;">
                    <p class="atasbawah" style="margin: 0; line-height: 1.5;">{{ $keterangan_lain }} </p>
                </td>
            </tr>       
            
        </table>
    </div>

    <div class="left">
        <p style="text-transform:initial;">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <table style="width: 100%; text-align: center; font-family: 'Times New Roman', Times, serif;">
        <tr>
            <td style="width: 33%;">Tanda Tangan Pemegang</td>
            <td style="width: 33%;"></td>
            <td style="width: 33%;">Kamal, {{ $tanggal }}<br>{{ $jabatan }}</td>
        </tr>
        <tr>
            <td style="height: 60px;"></td> 
        </tr>
        <tr>
            <td><u>{{ $nama_pemohon }}</u></td>
            <td>Mengetahui,<br>Camat Bulu,</td>
            <td><u>{{ $nama_pejabat }}</u></td>
        </tr>
        <tr>
            <td style="height: 60px;"></td> 
        </tr>
        <tr>
            <td></td>
            <td><u>..........................................</u></td> 
            <td></td>
    </table>
     
    
</body>
</html>