<?php

namespace App\Filament\Resources\PejabatResource\Pages;

use App\Filament\Resources\PejabatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Common\Traits\TitleCaseSanitizer;
class CreatePejabat extends CreateRecord
{   
    use TitleCaseSanitizer;
    protected static string $resource = PejabatResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = static::sanitizeTitleCase($data);
        return $data;
    }
}
