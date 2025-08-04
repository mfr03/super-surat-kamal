<?php

namespace App\Filament\Resources\BayiResource\Pages;

use App\Filament\Resources\BayiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Common\Traits\TitleCaseSanitizer;

class CreateBayi extends CreateRecord
{   
    use TitleCaseSanitizer;

    protected static string $resource = BayiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = static::sanitizeTitleCase($data);

        return $data;
    }
}
