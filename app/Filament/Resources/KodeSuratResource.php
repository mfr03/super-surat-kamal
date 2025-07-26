<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KodeSuratResource\Pages;
use App\Filament\Resources\KodeSuratResource\RelationManagers;
use App\Forms\Filaments\KodeSuratForms;
use App\Models\KodeSurat;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KodeSuratResource extends Resource
{
    protected static ?string $model = KodeSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Data Surat';


    public static function form(Form $form): Form
    {
        return $form
            ->schema(KodeSuratForms::form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                KodeSuratForms::table()
            )
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListKodeSurats::route('/'),
            'create' => Pages\CreateKodeSurat::route('/create'),
            // 'view' => Pages\ViewKodeSurat::route('/{record}'),
            'edit' => Pages\EditKodeSurat::route('/{record}/edit'),
        ];
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
