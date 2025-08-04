<?php

namespace App\Filament\Resources\BayiResource\Pages;

use App\Filament\Resources\BayiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Common\Traits\TitleCaseSanitizer;

class EditBayi extends EditRecord
{
    use TitleCaseSanitizer;
    protected static string $resource = BayiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = static::sanitizeTitleCase($data);

        return $data;
    }
}
