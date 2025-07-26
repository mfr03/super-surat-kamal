<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeteranganUsahaResource\Pages;
use App\Filament\Resources\SuratKeteranganUsahaResource\RelationManagers;
use App\Models\SuratKeteranganUsaha;
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
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Pejabat;


class SuratKeteranganUsahaResource extends Resource
{
    protected static ?string $model = SuratKeteranganUsaha::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Jenis Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                CustomComponents::sectionDataSurat(SuratKeteranganUsaha::class),

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

                        Forms\Components\Select::make('ibu_id')
                            ->label('Nama Ibu')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return Warga::where('nama', 'like', "%{$search}%")
                                    ->limit(10)
                                    ->pluck('nama', 'id');
                            })
                            ->required(),

                        Forms\Components\TextInput::make('selama')
                            ->label('Selama ...')
                            ->required(),
                        Forms\Components\TextInput::make('nama_usaha')
                            ->label('Nama Usaha')
                            ->required(),
                        Forms\Components\TextInput::make('tujuan_surat')
                            ->label('Tujuan Surat')
                            ->required()
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

                Tables\Columns\TextColumn::make('tujuan_surat')
                    ->label('Tujuan Surat')
                    ->searchable(),

                Tables\Columns\TextColumn::make('selama')
                    ->label('Selama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function($record) {
                    $pemohon = $record->warga; 
                    $ibu = Warga::find($record->ibu_id); 
                    $pejabat = Pejabat::where('jabatan', $record->jabatan_ttd)->first();
                    $data = [
                        'nomor' => $record->nomor_surat ?? '',
                        'nama_pejabat' => $pejabat->nama ?? '',
                        'jabatan' => $record->jabatan_ttd ?? '',
                        'nama' => $pemohon->nama ?? '',
                        'nik' => $pemohon->nik ?? '',
                        'jenis_kelamin' => $pemohon->jenis_kelamin ?? '',
                        'agama' => $pemohon->agama ?? '',
                        'ibu_kandung' => $ibu->nama ?? '',
                        'nomor_hp' => $pemohon->nomor_hp ?? '',
                        'domisili' => $pemohon->alamat ?? '',
                        'nama_usaha' => $record->nama_usaha ?? '',
                        'selama' => $record->selama ?? '',
                        'alasan' => $record->tujuan_surat ?? '',
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
                        echo \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.keterangan-usaha', $data)->output();
                    }, 'surat-keterangan-usaha-' . ($pemohon->nama ?? 'pemohon') . '.pdf');
                }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_by_month')
                    ->label('Ekspor Surat Keterangan Usaha Bulanan')
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

                        return redirect()->route('export.by-month-keterangan-usaha', [
                            'month' => $month,
                            'year' => $year
                        ]);
                    }),



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
            'index' => Pages\ListSuratKeteranganUsahas::route('/'),
            'create' => Pages\CreateSuratKeteranganUsaha::route('/create'),
            'edit' => Pages\EditSuratKeteranganUsaha::route('/{record}/edit'),
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
