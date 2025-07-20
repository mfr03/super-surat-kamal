<?php

namespace App\Filament\Resources\JenazahResource\Pages;

use App\Filament\Resources\JenazahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenazahs extends ListRecords
{
    protected static string $resource = JenazahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
