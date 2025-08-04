<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Common\Traits\TitleCaseSanitizer;
class CreateWarga extends CreateRecord
{   
    use TitleCaseSanitizer;
    protected static string $resource = WargaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = static::sanitizeTitleCase($data);
        return $data;
    }
}
