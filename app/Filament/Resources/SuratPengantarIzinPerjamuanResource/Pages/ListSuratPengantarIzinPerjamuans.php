<?php

namespace App\Filament\Resources\SuratPengantarIzinPerjamuanResource\Pages;

use App\Filament\Resources\SuratPengantarIzinPerjamuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratPengantarIzinPerjamuans extends ListRecords
{
    protected static string $resource = SuratPengantarIzinPerjamuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
