<?php


namespace App\Common;

use Filament\Forms\Components\Select;
use Closure;

class CustomComponents
{

    public static function searchSelect(
        string $column,
        string $label,
        string $searchColumn,
        string $placeholder,
        string $modelClass,
        array $autofillFields,
        Closure $createForm,
        Closure $createUsing
    ): Select {
        return Select::make($column)
            ->label($label)
            ->placeholder($placeholder)
            ->reactive()
            ->searchable()
            ->getSearchResultsUsing(function (string $search) use ($modelClass, $searchColumn) {
                return $modelClass::where($searchColumn, 'like', "%{$search}%")
                    ->limit(10)
                    ->pluck($searchColumn, 'id');
            })
            ->getOptionLabelUsing(function ($value) use ($modelClass, $searchColumn): ?string {
                return $modelClass::find($value)?->$searchColumn;
            })
            ->afterStateUpdated(function ($state, callable $set) use ($modelClass, $autofillFields) {
                $model = $modelClass::find($state);
                if($model && !empty($autofillFields)) {
                    foreach ($autofillFields as $modelKey => $formFieldKey) {
                        $set($formFieldKey, $model->$modelKey);
                    }
                }
            })
            ->createOptionForm($createForm)
            ->createOptionUsing($createUsing)
            ->required();
    }
    
}