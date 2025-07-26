<?php

namespace App\Filament\Resources;

use App\Constants\FormsConst;
use App\Filament\Resources\SuratKelahiranResource\Pages;
use App\Forms\Filaments\WargaForms;
use App\Models\SuratKelahiran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Bayi;
use App\Models\Warga;
use Filament\Forms\Components\Select;
use App\Forms\Filaments\BayiForms;
use Closure;
use \Illuminate\Support\Str;
use App\Common\CustomComponents;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratKelahiranExport;


class SuratKelahiranResource extends Resource
{
    protected static ?string $model = SuratKelahiran::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Jenis Surat';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                CustomComponents::sectionDataSurat(SuratKelahiran::class,
            Forms\Components\TextInput::make('kode_wilayah')
                ->label('Kode Wilayah')
                ->required()
                ->maxLength(255)
            ),


                Forms\Components\Section::make('Data Kepala Keluarga')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('nama_kepala_keluarga')
                            ->label('Nama Kepala Keluarga')
                            ->autofocus()
                            ->required()
                            ->autocapitalize('words')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nomor_kepala_keluarga')
                            ->label('Nomor Kepala Keluarga')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Data Bayi')
                ->schema([
                    CustomComponents::searchSelect(
                    'bayi_id', 'Nama Bayi',
                    'nama', 'Masukkan nama bayi',
                    Bayi::class, BayiForms::fieldMapMinusName(),
                    fn () => BayiForms::fields(),
                    fn (array $data) => Bayi::create($data)->getKey()
                    ),
                    ...BayiForms::fieldsMinusName(true)
                ])
                ->collapsible(),

                Forms\Components\Section::make('Data Ibu')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'ibu_id', 'Nama Ibu',
                        'nama', 'Masukkan Nama Ibu',
                        Warga::class, WargaForms::fieldMap(FormsConst::IBU),
                        fn () => WargaForms::fields(true, FormsConst::IBU),
                        fn (array $data) => Warga::create(
                            collect($data)
                                ->mapWithKeys(fn ($value, $key) => [Str::after($key, FormsConst::IBU) => $value])
                                ->all()
                            )->getKey()
                    ),
                    ...WargaForms::fieldsUnique(true, true, FormsConst::IBU)
                ]),
                Forms\Components\Section::make('Data Ayah')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'ayah_id', 'Nama Ayah',
                        'nama', 'Masukkan Nama Ayah',
                        Warga::class,WargaForms::fieldMap(FormsConst::AYAH),
                        fn () => WargaForms::fields(false, FormsConst::AYAH),
                        fn (array $data) => Warga::create(
                            collect($data)
                                ->mapWithKeys(fn ($value, $key) => [Str::after($key, FormsConst::AYAH) => $value])
                                ->all()
                            )->getKey()
                    ),
                    ...WargaForms::fieldsUnique(true, false, FormsConst::AYAH)
                ]),
                Forms\Components\Section::make('Data Pelapor')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'pelapor_id', 'Nama Pelapor',
                        'nama', 'Masukkan Nama Pelapor',
                        Warga::class,WargaForms::fieldMap(FormsConst::PELAPOR),
                        fn () => WargaForms::fields(false, FormsConst::PELAPOR),
                        fn (array $data) => Warga::create(
                            collect($data)
                                ->mapWithKeys(fn ($value, $key) => [Str::after($key, FormsConst::PELAPOR) => $value])
                                ->all()
                            )->getKey()
                    ),
                    ...WargaForms::fieldsUnique(true, false,FormsConst::PELAPOR)
                ]),
                Forms\Components\Section::make('Data Saksi Satu')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'saksi_satu_id', 'Nama Saksi Satu',
                        'nama', 'Masukkan Nama Saksi Satu',
                        Warga::class,WargaForms::fieldMap(FormsConst::SAKSI_SATU),
                        fn () => WargaForms::fields(false, FormsConst::SAKSI_SATU),
                        fn (array $data) => Warga::create(
                            collect($data)
                                ->mapWithKeys(fn ($value, $key) => [Str::after($key, FormsConst::SAKSI_SATU) => $value])
                                ->all()
                            )->getKey()
                    ),
                    ...WargaForms::fieldsUnique(true, false, FormsConst::SAKSI_SATU)
                ]),
                Forms\Components\Section::make('Data Saksi Dua')
                ->collapsible()
                ->schema([
                    CustomComponents::searchSelect(
                        'saksi_dua_id', 'Nama Saksi Dua',
                        'nama', 'Masukkan Nama Saksi Dua',
                        Warga::class,WargaForms::fieldMap(FormsConst::SAKSI_DUA),
                        fn () => WargaForms::fields(false, FormsConst::SAKSI_DUA),
                        fn (array $data) => Warga::create(
                            collect($data)
                                ->mapWithKeys(fn ($value, $key) => [Str::after($key, FormsConst::SAKSI_DUA) => $value])
                                ->all()
                            )->getKey()
                    ),
                    ...WargaForms::fieldsUnique(true, false, FormsConst::SAKSI_DUA)
                ]),
            ]);
    }    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_kepala_keluarga')
                    ->label('Nama Kepala Keluarga')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nomor_kepala_keluarga')
                    ->label('Nomor Kepala Keluarga')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bayi.nama')
                    ->label('Nama Bayi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ibu.nama')
                    ->label('Nama Ibu')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ayah.nama')
                    ->label('Nama Ayah')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pelapor.nama')
                    ->label('Nama Pelapor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('saksiSatu.nama')
                    ->label('Nama Saksi Satu')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('saksiDua.nama')
                    ->label('Nama Saksi Dua')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function ($record) {
                    $bayi = $record->bayi;
                    $ibu = $record->ibu;
                    $ayah = $record->ayah;
                    $pelapor = $record->pelapor;
                    $saksi1 = $record->saksiSatu;
                    $saksi2 = $record->saksiDua;
                    $pejabat = \App\Models\Pejabat::where('jabatan', $record->jabatan_ttd)->first();

                    $umur_ibu = $ibu ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->age : '';
                    $umur_ayah = $ayah ? \Carbon\Carbon::parse($ayah->tanggal_lahir)->age : '';
                    $umur_pelapor = $pelapor ? \Carbon\Carbon::parse($pelapor->tanggal_lahir)->age : '';
                    $umur_saksi1 = $saksi1 ? \Carbon\Carbon::parse($saksi1->tanggal_lahir)->age : '';
                    $umur_saksi2 = $saksi2 ? \Carbon\Carbon::parse($saksi2->tanggal_lahir)->age : '';

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
                    $data = array_map(function ($value) {
                        if (is_string($value)) {
                            $value = str_replace("\0", '', $value);
                            $value = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $value);
                            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                        return $value;
                    }, $data);

                    return response()->streamDownload(function () use ($data) {
                        echo \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.kelahiran', $data)->output();
                    }, 'surat-kelahiran-' . $record->nama_kepala_keluarga . '.pdf');
                }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_by_month')
                    ->label('Ekspor Surat Kelahiran Bulanan')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        Forms\Components\DatePicker::make('month')
                            ->label('Bulan')
                            ->required()
                            ->displayFormat('F Y')
                            ->format('Y-m')
                            ->maxDate(now())
                            ->default(now())
                            ->native(false)
                            ->closeOnDateSelection(true)
                            ->extraAttributes([
                                'autocomplete' => 'off',
                                'data-type' => 'month',
                                'onfocus' => "this.type='month'",
                                'onblur' => "this.type='text'",
                            ]),
                    ])
                ->action(function (array $data) {
                    $month = \Carbon\Carbon::parse($data['month'])->month;
                    $year = \Carbon\Carbon::parse($data['month'])->year;

                    // Return a redirect response
                    return redirect()->route('export.by-month-kelahiran', [
                        'month' => $month,
                        'year' => $year,
                    ]);
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKelahirans::route('/'),
            'create' => Pages\CreateSuratKelahiran::route('/create'),
            'edit' => Pages\EditSuratKelahiran::route('/{record}/edit'),
        ];
    }

    public static function updateNomorSurat(Set $set, Get $get): void {

        $kodeSuratId = $get('kode_surat');
        $nomor = $get('nomor');

        if (! $kodeSuratId || ! $nomor) {
            $set('nomor_surat', null);
            return;
        }

        $kodeSurat = \App\Models\KodeSurat::find($kodeSuratId)?->kode ?? '';
        $monthRoman = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][Carbon::now()->month];
        $year = Carbon::now()->year;

        $nomorSurat = "{$kodeSurat}/{$nomor}/{$monthRoman}/{$year}";

        $set('nomor_surat', $nomorSurat);

    }

}
