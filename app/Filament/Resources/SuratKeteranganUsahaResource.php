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
use Illuminate\Support\Str;


class SuratKeteranganUsahaResource extends Resource
{
    protected static ?string $model = SuratKeteranganUsaha::class;

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
                                KodeSurat::query()
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
                        Forms\Components\TextInput::make('selama')
                            ->label('Selama ...')
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
                //
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
            'index' => Pages\ListSuratKeteranganUsahas::route('/'),
            'create' => Pages\CreateSuratKeteranganUsaha::route('/create'),
            'edit' => Pages\EditSuratKeteranganUsaha::route('/{record}/edit'),
        ];
    }
}
