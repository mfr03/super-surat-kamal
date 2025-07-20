<?php

namespace App\Filament\Resources\SuratKeteranganUsahaResource\Pages;

use App\Filament\Resources\SuratKeteranganUsahaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratKeteranganUsahas extends ListRecords
{
    protected static string $resource = SuratKeteranganUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
