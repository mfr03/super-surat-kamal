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


class SuratKelahiranResource extends Resource
{
    protected static ?string $model = SuratKelahiran::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Jenis Surat';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                CustomComponents::sectionDataSurat(SuratKelahiran::class),


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
