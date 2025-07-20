<?php

namespace App\Filament\Resources\SuratPengantarResource\Pages;

use App\Filament\Resources\SuratPengantarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratPengantars extends ListRecords
{
    protected static string $resource = SuratPengantarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
