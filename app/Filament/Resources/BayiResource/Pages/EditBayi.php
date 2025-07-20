<?php

namespace App\Filament\Resources\BayiResource\Pages;

use App\Filament\Resources\BayiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBayi extends EditRecord
{
    protected static string $resource = BayiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
