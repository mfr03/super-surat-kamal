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


class SuratPengantarResource extends Resource
{
    protected static ?string $model = SuratPengantar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Data Surat')
                    ->collapsible()
                    ->schema([

                        Forms\Components\Select::make('kode_surat')
                            ->label('Pilih Kode Surat')
                            ->options(
                                \App\Models\KodeSurat::query()
                                    ->get()
                                    ->mapWithKeys(function ($item) {
                                    return [$item->id => "{$item->kode}: {$item->detail}"]; 
                                    })
                                )
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                self::updateNomorSurat($set, $get);
                            }),
                        
                        Forms\Components\TextInput::make('nomor')
                            ->label('Nomor')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                self::updateNomorSurat($set, $get);
                            }),

                        Forms\Components\TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->required()
                            ->disabled(true),

                        Forms\Components\Select::make('jabatan_ttd')
                            ->label('Pilih Jabatan TTD')
                            ->columnSpanFull()
                            ->options([
                                'kepala_desa' => 'Kepala Desa Kamal',
                                'sekdes' => 'Sekretaris Desa',
                                'kaur_tu' => 'Kaur TU',
                            ])
                            ->required(),

                    ]),

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
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan_ttd')
                    ->searchable(),
                Tables\Columns\TextColumn::make('warga.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kartu_keluarga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keperluan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('berlaku_mulai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
