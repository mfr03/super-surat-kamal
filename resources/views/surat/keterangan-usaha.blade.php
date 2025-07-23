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
        <div id="lampiran" class="lampiran">
            No Kode Desa/Kelurahan<br />
            33 11 022002
          </div>
    </div>

    <div class="tengah suratbold">
        <p>SURAT KETERANGAN USAHA</p>
    </div>
    <div class="tengah" style="padding-right: 0px;">
        <p>Nomor: {{ $nomor }}</p>
    </div>
    <br>
    <div class="content">
        
        <p>Yang bertanda tangan dibawah ini:</p>

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
                <td style="text-align:left; ">NIK</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $nik }}</p>
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
                <td style="text-align:left; ">Nama Ibu Kandung</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $ibu_kandung }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; ">Nomor HP</td>
                <td style="text-align:center;">:</td>
                <td>
                    <p class="atasbawah">{{ $nomor_hp }}</p>
                </td>
            </tr>
            
           
            
        </table>
    </div>

    <div class="left">
        {{-- <p>Adalah benar penduduk yang berdomisili di {{ $domisili }} </p> --}}
        <p style="text-transform:inherit;">ADALAH BENAR PENDUDUK YANG BERDOMISILI DI {{ strtoupper($domisili) }} </p>
        {{-- <p>Berdasarkan sepengetahuan kami bahwa nama tersebut diatas adalah benar mempunyai usaha bertani selama &plusmn; {{ $selama }}</p> --}}
        <p style="text-transform:initial">BERDASARKAN SEPENGETAHUAN KAMI BAHWA NAMA TERSEBUT DIATAS ADALAH BENAR MEMPUNYAI USAHA {{ strtoupper($nama_usaha) }} SELAMA {{ strtoupper($selama) }}</p>
        {{-- <p>Adapun surat keterangan ini dibuat untuk {{ $alasan }}</p> --}}
        <p style="text-transform:initial;">ADAPUN SURAT KETERANGAN INI DIBUAT UNTUK {{ strtoupper($alasan) }}</p>
        <p>Demikian surat keterangan usaha ini dibuat untuk dapat dipergunakan sebagaimana mestinya dan bagi instansi yang berkepentingan menjadi bahan periksa adanya</p>
        <br>

    
    </div>


    <table style="width:100%;  table-layout:fixed; margin: 0px; ">
        <tr>
           
            <td style="width:25%; text-align:center;">
                <div class="tanda_tangan" id="ybs" >
                    
                </div>   
            </td>
            <td style="width:50%; text-align:left;">
                <!-- <div class="tanda_tangan" id="ybs" >
                    <br>
                    <div class="kosong">Yang Bersangkutan</div>
                    <br>
                    <br>
                    <br>
                    <div id="nama_pemohon" style="text-transform:uppercase;"></div>
                </div>    -->
            </td>
            <td style="width:30%; text-align:center;">
                <div class="tanda_tangan">
                    <div>Kamal, {{ $tanggal }} </div>
                    <div class="kosong" id="pejabat">

                        <p style="margin: 0px;">{{ $jabatan }}</p>

                    </div>
                    <div id="nama_pejabat">
                        <br><br><br><br>
                        <span style="text-transform:uppercase;">
                            {{ $nama_pejabat }}
                        </span>
                    </div>

                </div>
            </td>
            
        </tr>
        
        
    </table>
     
    
</body>
</html>