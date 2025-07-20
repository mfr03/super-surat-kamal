<?php

namespace App\Filament\Resources\JenazahResource\Pages;

use App\Filament\Resources\JenazahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenazah extends EditRecord
{
    protected static string $resource = JenazahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
