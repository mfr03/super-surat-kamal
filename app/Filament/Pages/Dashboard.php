<?php

namespace App\Filament\Pages;

use App\Filament\Resources\SuratKelahiranResource\Widgets\StatsSuratKelahiran;
use App\Filament\Resources\SuratKematianResource\Widgets\StatsSuratKematian;
use App\Filament\Resources\SuratKeteranganUsahaResource\Widgets\StatsSuratKeteranganUsaha;
use App\Filament\Resources\SuratPengantarIzinPerjamuanResource\Widgets\StatsSuratPengantarIzinPerjamuan;    
use App\Filament\Resources\SuratPengantarResource\Widgets\StatsSuratPengantar;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Facades\FilamentIcon;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            static::$title ??
            __('filament-panels::pages/dashboard.title');
    }

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            StatsSuratKelahiran::class,
            StatsSuratKematian::class,
            StatsSuratPengantar::class,
            StatsSuratKeteranganUsaha::class,
            StatsSuratPengantarIzinPerjamuan::class,    
        ];
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getTitle(): string | Htmlable
    {
        return static::$title ?? __('filament-panels::pages/dashboard.title');
    }

}
