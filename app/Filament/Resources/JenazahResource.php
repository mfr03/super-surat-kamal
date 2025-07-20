<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenazahResource\Pages;
use App\Filament\Resources\JenazahResource\RelationManagers;
use App\Forms\Filaments\JenazahForms;
use App\Models\Jenazah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenazahResource extends Resource
{
    protected static ?string $model = Jenazah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(JenazahForms::form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(JenazahForms::table())
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
            'index' => Pages\ListJenazahs::route('/'),
            'create' => Pages\CreateJenazah::route('/create'),
            'edit' => Pages\EditJenazah::route('/{record}/edit'),
        ];
    }
}
