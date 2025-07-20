<?php

namespace App\Filament\Resources\BayiResource\Pages;

use App\Filament\Resources\BayiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBayis extends ListRecords
{
    protected static string $resource = BayiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
