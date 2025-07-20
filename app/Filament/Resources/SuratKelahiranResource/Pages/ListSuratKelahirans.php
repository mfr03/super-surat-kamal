<?php

namespace App\Filament\Resources\SuratKelahiranResource\Pages;

use App\Filament\Resources\SuratKelahiranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratKelahirans extends ListRecords
{
    protected static string $resource = SuratKelahiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
