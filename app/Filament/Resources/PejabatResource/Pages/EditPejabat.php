<?php

namespace App\Filament\Resources\PejabatResource\Pages;

use App\Filament\Resources\PejabatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Common\Traits\TitleCaseSanitizer;
class EditPejabat extends EditRecord
{
    use TitleCaseSanitizer;
    protected static string $resource = PejabatResource::class;

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
