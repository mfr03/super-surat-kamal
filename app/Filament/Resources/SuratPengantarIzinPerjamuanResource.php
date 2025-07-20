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

class SuratPengantarIzinPerjamuanResource extends Resource
{
    protected static ?string $model = SuratPengantarIzinPerjamuan::class;

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
                        Forms\Components\TextInput::make('hari_tanggal')
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
            'index' => Pages\ListSuratPengantarIzinPerjamuans::route('/'),
            'create' => Pages\CreateSuratPengantarIzinPerjamuan::route('/create'),
            'edit' => Pages\EditSuratPengantarIzinPerjamuan::route('/{record}/edit'),
        ];
    }
}
