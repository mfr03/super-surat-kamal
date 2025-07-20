<?php

namespace App\Filament\Resources\KodeSuratResource\Pages;

use App\Filament\Resources\KodeSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKodeSurat extends ViewRecord
{
    protected static string $resource = KodeSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
