<?php

namespace App\Filament\Resources\SuratPengantarResource\Pages;

use App\Filament\Resources\SuratPengantarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratPengantar extends EditRecord
{
    protected static string $resource = SuratPengantarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
