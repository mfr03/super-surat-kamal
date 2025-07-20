<?php

namespace App\Forms\Filaments;

use Filament\Forms;
use Filament\Tables;
class KodeSuratForms
{
    public static function form(): array
    {
        return [
                Forms\Components\TextInput::make('kode')
                ->required()
                ->maxLength(5),
                Forms\Components\TextInput::make('detail')
                ->required()
                ->maxLength(10)
            ];
    }
    

    public static function table(): array
    {
        return [
                Tables\Columns\TextColumn::make('kode')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('detail')
        ];
    }
}