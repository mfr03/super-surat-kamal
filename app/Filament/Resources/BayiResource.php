<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BayiResource\Pages;
use App\Filament\Resources\BayiResource\RelationManagers;
use App\Forms\Filaments\BayiForms;
use App\Models\Bayi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BayiResource extends Resource
{
    protected static ?string $model = Bayi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(BayiForms::form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(components: BayiForms::table())
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
            'index' => Pages\ListBayis::route('/'),
            'create' => Pages\CreateBayi::route('/create'),
            'edit' => Pages\EditBayi::route('/{record}/edit'),
        ];
    }
}
