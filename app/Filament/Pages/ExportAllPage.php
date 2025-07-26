<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;
use App\Exports\AllSuratExport;

class ExportAllPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.export-all-page';

    public function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Monthly Report')
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->form([
                        DatePicker::make('month')
                            ->label('Bulan')
                            ->required()
                            ->displayFormat('F Y')
                            ->format('Y-m')
                            ->maxDate(now())
                            ->default(now())
                            ->native(false)
                            ->closeOnDateSelection(true)
                            ->extraAttributes([
                                'autocomplete' => 'off',
                                'data-type' => 'month',
                                'onfocus' => "this.type='month'",
                                'onblur' => "this.type='text'",
                            ]),
                ])
                ->action(function (array $data) {
                    $month = Carbon::parse($data['month'])->month;
                    $year = Carbon::parse($data['month'])->year;

                    return redirect()->route('export.all-surat', [
                        'month' => $month,
                        'year' => $year,
                    ]);
                }),
        ];
    }







}
