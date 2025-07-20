<?php

namespace App\Filament\Resources\KodeSuratResource\Pages;

use App\Filament\Resources\KodeSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKodeSurat extends EditRecord
{
    protected static string $resource = KodeSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
