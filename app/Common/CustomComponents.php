<?php


namespace App\Common;

use Filament\Forms\Components\Select;
use Closure;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Carbon;

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
        Closure $createUsing,
        ?Closure $extraHydrated = null
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
                        $value = $model->$modelKey;
                        if ($value instanceof \Carbon\Carbon) {
                            $value = $value->format('Y-m-d');
                        }
                        $set($formFieldKey, $value);
                    }
                }
            })
            ->afterStateHydrated(function ($state, callable $set) use ($modelClass, $autofillFields, $extraHydrated) {
                $model = $modelClass::find($state);
                if($model && !empty($autofillFields)) {
                    foreach ($autofillFields as $modelKey => $formFieldKey) {
                        $value = $model->$modelKey;
                        if ($value instanceof \Carbon\Carbon) {
                            $value = $value->format('Y-m-d');
                        }
                        $set($formFieldKey, $value);
                    }
                }

                if($extraHydrated) {
                    $extraHydrated($state, $set);
                }
            })
            ->createOptionForm($createForm)
            ->createOptionUsing($createUsing)
            ->required();
    }

    public static function sectionDataSurat(string $modelClass): Section
    {
        return Section::make('Data Surat')
                    ->collapsible()
                    ->schema([

                        Select::make('kode_surat')
                            ->label('Pilih Kode Surat')
                            ->options(
                                \App\Models\KodeSurat::query()
                                    ->get()
                                    ->mapWithKeys(function ($item) {
                                        return [$item->id => "{$item->kode}: {$item->detail}"];
                                    })
                            )
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                self::updateNomorSurat($set, $get);
                            })
                            ->dehydrated(false),
                        
                        TextInput::make('nomor')
                            ->label('Nomor')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                self::updateNomorSurat($set, $get);
                            }),

                        TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->required()
                            ->readOnly()
                            ->placeholder('474.1/xxx/mm/yyyy')
                            ->hint('Nomor surat terakhir: ' . $modelClass::latest('created_at')->value('nomor_surat')),

                        Select::make('jabatan_ttd')
                            ->label('Pilih Jabatan TTD')
                            ->columnSpanFull()
                            ->options(\App\Models\Pejabat::pluck('jabatan', 'jabatan')->toArray())
                            ->required(),

             ]);
    }

    public static function updateNomorSurat(Set $set, Get $get): void {

        $kodeSuratId = $get('kode_surat');
        $nomor = $get('nomor');

        if (! $kodeSuratId || ! $nomor) {
            $set('nomor_surat', null);
            return;
        }

        $kodeSurat = \App\Models\KodeSurat::find($kodeSuratId)?->kode ?? '';
        $monthRoman = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][Carbon::now()->month];
        $year = Carbon::now()->year;

        $nomorSurat = "{$kodeSurat}/{$nomor}/{$monthRoman}/{$year}";

        $set('nomor_surat', $nomorSurat);

    }
    
}