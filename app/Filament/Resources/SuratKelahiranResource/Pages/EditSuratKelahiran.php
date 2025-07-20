<?php

namespace App\Filament\Resources\SuratKelahiranResource\Pages;

use App\Filament\Resources\SuratKelahiranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratKelahiran extends EditRecord
{
    protected static string $resource = SuratKelahiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
