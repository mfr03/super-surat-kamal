<?php

namespace App\Forms\Filaments;

use Filament\Forms;
use Filament\Tables;
class PejabatForms
{
    public static function form(): array
    {
        return [
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255)
            ];
    }
    

    public static function table(): array
    {
        return [
                Tables\Columns\TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->sortable()
                    ->searchable(),

        ];
    }
}