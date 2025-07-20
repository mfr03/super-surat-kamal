<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKematianResource\Pages;
use App\Filament\Resources\SuratKematianResource\RelationManagers;
use App\Models\SuratKematian;
use App\Models\SuratKelahiran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Forms\Filaments\JenazahForms;

class SuratKematianResource extends Resource
{
    protected static ?string $model = SuratKematian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Section::make('Data Surat')
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->required()
                        ->placeholder('474.1/xxx/mm/yyyy')
                        ->hint('Nomor surat terakhir: ' . SuratKelahiran::latest('created_at')->value('nomor_surat'))
                        ->reactive()
                        ->maxLength(255),
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

                ...JenazahForms::form(),
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
            'index' => Pages\ListSuratKematians::route('/'),
            'create' => Pages\CreateSuratKematian::route('/create'),
            'edit' => Pages\EditSuratKematian::route('/{record}/edit'),
        ];
    }
}
