<?php

namespace App\Filament\Resources\SuratKematianResource\Widgets;

use App\Models\SuratKematian;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsSuratKematian extends BaseWidget
{
    protected ?string $heading = 'Statistik Surat Kematian';

    protected function getStats(): array
    {
        $totalSurat = SuratKematian::count();
        $suratHariIni = SuratKematian::whereDate('created_at', today())->count();
        $suratBulanIni = SuratKematian::whereMonth('created_at', Carbon::now()->month)->count();

        return [
            Stat::make('Total Surat Kematian Terbuat', $totalSurat)
                ->chart($this->getTotalSuratChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Surat Kematian Hari Ini', $suratHariIni)
                ->chart($this->getSuratChartData())
                ->color('danger'),

            Stat::make('Surat Kematian Bulan Ini', $suratBulanIni)
                ->chart($this->getMonthlySuratChartData())
                ->color('info'),
        ];
    }

    protected function getTotalSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratKematian::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratKematian::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlySuratChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = SuratKematian::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }
}