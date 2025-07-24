<?php

namespace App\Filament\Resources\SuratPengantarResource\Widgets;

use App\Models\SuratPengantar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsSuratPengantar extends BaseWidget
{
    protected ?string $heading = 'Statistik Surat Pengantar';

    protected function getStats(): array
    {
        $totalSurat = SuratPengantar::count();
        $suratHariIni = SuratPengantar::whereDate('created_at', today())->count();
        $suratBulanIni = SuratPengantar::whereMonth('created_at', Carbon::now()->month)->count();

        return [
            Stat::make('Total Surat Pengantar', $totalSurat)
                ->chart($this->getTotalSuratChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Surat Pengantar Hari Ini', $suratHariIni)
                ->chart($this->getSuratChartData())
                ->color('success'),

            Stat::make('Surat Pengantar Bulan Ini', $suratBulanIni)
                ->chart($this->getMonthlySuratChartData())
                ->color('info'),
        ];
    }

    protected function getTotalSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratPengantar::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratPengantar::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlySuratChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = SuratPengantar::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }
}