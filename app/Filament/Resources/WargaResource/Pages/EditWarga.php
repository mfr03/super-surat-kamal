<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Common\Traits\TitleCaseSanitizer;
class EditWarga extends EditRecord
{   
    use TitleCaseSanitizer;
    protected static string $resource = WargaResource::class;

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
