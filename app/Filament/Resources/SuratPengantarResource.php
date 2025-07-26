<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratPengantarResource\Pages;
use App\Filament\Resources\SuratPengantarResource\RelationManagers;
use App\Models\SuratPengantar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Carbon;
use App\Common\CustomComponents;
use App\Models\Warga;
use App\Forms\Filaments\WargaForms;
use App\Constants\FormsConst;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pejabat;

class SuratPengantarResource extends Resource
{
    protected static ?string $model = SuratPengantar::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static ?string $navigationGroup = 'Jenis Surat';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                CustomComponents::sectionDataSurat(SuratPengantar::class),

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
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tujuan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('berlaku_mulai')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('keterangan')
                            ->required()
                            ->maxLength(255),
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tujuan')
                    ->label('Tujuan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('berlaku_mulai')
                    ->label('Berlaku Mulai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Export PDF')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action((function ($record) {
                        $pemohon = $record->warga;
                        $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();
                        $data = [
                            'nomor' => $record->nomor_surat ?? '',
                            'nama' => $pemohon->nama ?? '',
                            'tempat_tanggal_lahir' => ($pemohon->tempat_lahir ?? '') . ', ' . (
                                $pemohon->tanggal_lahir
                                    ? Carbon::parse($pemohon->tanggal_lahir)->format('d-m-Y')
                                    : ''
                            ),
                            'kewarganegaraan' => $pemohon->kewarganegaraan ?? 'Indonesia',
                            'agama' => $pemohon->agama ?? '',
                            'pekerjaan' => $pemohon->pekerjaan ?? '',
                            'tempat_tinggal' => $pemohon->alamat ?? '',
                            'nik' => $pemohon->nik ?? '',
                            'kk' => $pemohon->kartu_keluarga ?? '',
                            'keperluan' => $record->keperluan ?? '',
                            'berlaku_mulai' => $record->berlaku_mulai ?? '',
                            'berlaku_sampai' => $record->berlaku_sampai ?? '',
                            'keterangan_lain' => $record->keterangan ?? '',
                            'tanggal' => now()->translatedFormat('j F Y'),
                            'jabatan' => $record->jabatan_ttd ?? '',
                            'nama_pejabat' => $pejabat->nama ?? '',
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
                            echo Pdf::loadView('surat.pengantar', $data)->output();
                        }, 'surat-pengantar-' . $pemohon->nama . '.pdf');
                        
                    })),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_by_month')
                    ->label('Ekspor Surat Pengantar Bulanan')
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
                                'onfucus' => "this.type='month'",
                                'onblur' => "this.type='text'",
                        ])
                    ])
                    ->action(function (array $data) {
                        $month = Carbon::parse($data['month'])->month;
                        $year = Carbon::parse($data['month'])->year;
                        return redirect()->route('export.by-month-pengantar', 
                        ['month' => $month, 'year' => $year]
                    );
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
            'index' => Pages\ListSuratPengantars::route('/'),
            'create' => Pages\CreateSuratPengantar::route('/create'),
            'edit' => Pages\EditSuratPengantar::route('/{record}/edit'),
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
