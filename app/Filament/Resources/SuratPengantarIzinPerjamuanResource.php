<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratPengantarIzinPerjamuanResource\Pages;
use App\Filament\Resources\SuratPengantarIzinPerjamuanResource\RelationManagers;
use App\Models\SuratPengantarIzinPerjamuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\KodeSurat;
use App\Models\Warga;
use App\Forms\Filaments\WargaForms;
use App\Constants\FormsConst;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Common\CustomComponents;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class SuratPengantarIzinPerjamuanResource extends Resource
{
    protected static ?string $model = SuratPengantarIzinPerjamuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Jenis Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                CustomComponents::sectionDataSurat(SuratPengantarIzinPerjamuan::class),

                Forms\Components\Section::make('Pemohon Surat')
                    ->collapsible()
                    ->schema([
                        CustomComponents::searchSelect(
                            'warga_id', 'Nama Pemohon',
                            'nama', 'Masukkan Nama Pemohon',
                            Warga::class, WargaForms::fieldMap(FormsConst::PEMOHON),
                            fn () => WargaForms::fields(false, FormsConst::PEMOHON),
                            fn (array $data) => Warga::create(
                                collect($data)
                                    ->mapWithKeys(fn($value, $key) => [Str::after($key, FormsConst::PEMOHON) => $value])
                                    ->all()
                            )->getKey()
                        ),
                        ...WargaForms::fieldsUnique(true, false, FormsConst::PEMOHON)
                    ]),
                
                Forms\Components\Section::make('Keterangan Surat')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('keperluan')
                            ->label('Keperluan')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Pernikahan, Khitanan, dll'),
                        Forms\Components\Textarea::make('undangan')
                            ->label('Undangan')
                            ->required()
                            ->maxLength(500)
                            ->helperText('Contoh: 2000 Orang'),
                        Forms\Components\TextInput::make('jenis_pertunjukan')
                            ->label('Jenis Pertunjukan')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Musik, Tari, dll'),
                        Forms\Components\TextInput::make('hari-tanggal')
                            ->label('Hari dan Tanggal')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Senin, 1 Januari 2024'),
                        Forms\Components\TextInput::make('berlaku_mulai')
                            ->label('Berlaku Mulai')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: 11 Juni 2025 S / D Selesai'),

                        Forms\Components\TextInput::make('keterangan_lain_lain')
                            ->label('Keterangan Lain-Lain')
                            ->required()
                            ->maxLength(255)
                    ])
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

                Tables\Columns\TextColumn::make('warga.nama')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('keperluan')
                    ->label('Keperluan')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('undangan')
                    ->label('Undangan')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_pertunjukan')
                    ->label('Jenis Pertunjukan')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('hari_tanggal')
                    ->label('Hari & Tanggal')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('berlaku_mulai')
                    ->label('Berlaku Mulai')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('keterangan_lain_lain')
                    ->label('Keterangan Lain-Lain')
                    ->limit(30)
                    ->searchable(),

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
                        $month = Carbon::parse($data['month'])->month;
                        $year = Carbon::parse($data['month'])->year;

                        return redirect()->route('export.by-month-pengantar-izin-perjamuan', [
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
            'index' => Pages\ListSuratPengantarIzinPerjamuans::route('/'),
            'create' => Pages\CreateSuratPengantarIzinPerjamuan::route('/create'),
            'edit' => Pages\EditSuratPengantarIzinPerjamuan::route('/{record}/edit'),
        ];
    }

    public static function updateNomorSurat(Set $set, Get $get): void {

        $kodeSuratId = $get('kode_surat');
        $nomor = $get('nomor');

        if (! $kodeSuratId || ! $nomor) {
            $set('nomor_surat', null);
            return;
        }

        $kodeSurat = KodeSurat::find($kodeSuratId)?->kode ?? '';
        $monthRoman = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][Carbon::now()->month];
        $year = Carbon::now()->year;

        $nomorSurat = "{$kodeSurat}/{$nomor}/{$monthRoman}/{$year}";

        $set('nomor_surat', $nomorSurat);

    }

}
