<?php

namespace App\Filament\Resources\SuratKelahiranResource\Widgets;

use App\Models\SuratKelahiran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsSuratKelahiran extends BaseWidget
{
    protected ?string $heading = 'Statistik Surat Kelahiran';

    protected function getStats(): array
    {
        $totalSurat = SuratKelahiran::count();
        $suratHariIni = SuratKelahiran::whereDate('created_at', today())->count();
        $suratBulanIni = SuratKelahiran::whereMonth('created_at', Carbon::now()->month)->count();


        return [
            Stat::make('Total Surat Kelahiran Terbuat', $totalSurat)
                ->chart($this->getTotalSuratChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Surat Kelahiran Hari Ini', $suratHariIni)
                ->chart($this->getSuratChartData())
                ->color('success'),

            Stat::make('Surat Kelahiran Bulan Ini', $suratBulanIni)
                ->chart($this->getMonthlySuratChartData())
                ->color('info'),
        ];
    }

    protected function getTotalSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratKelahiran::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratKelahiran::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlySuratChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = SuratKelahiran::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }



}
