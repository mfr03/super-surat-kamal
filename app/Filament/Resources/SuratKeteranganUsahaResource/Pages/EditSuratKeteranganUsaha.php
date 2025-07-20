<?php

namespace App\Filament\Resources\SuratKeteranganUsahaResource\Pages;

use App\Filament\Resources\SuratKeteranganUsahaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratKeteranganUsaha extends EditRecord
{
    protected static string $resource = SuratKeteranganUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
