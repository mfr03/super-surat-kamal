<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PejabatResource\Pages;
use App\Filament\Resources\PejabatResource\RelationManagers;
use App\Forms\Filaments\PejabatForms;
use App\Models\Pejabat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Spatie\Permission\Models\Role;

class PejabatResource extends Resource
{
    protected static ?string $model = Pejabat::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ...PejabatForms::form()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...PejabatForms::table()
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
            'index' => Pages\ListPejabats::route('/'),
            'create' => Pages\CreatePejabat::route('/create'),
            'edit' => Pages\EditPejabat::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()?->hasRole('admin');
    }

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()?->hasRole('admin');
    }


}
