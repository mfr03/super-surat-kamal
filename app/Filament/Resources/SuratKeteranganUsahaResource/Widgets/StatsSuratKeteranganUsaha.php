<?php


namespace App\Filament\Resources\SuratKeteranganUsahaResource\Widgets;

use App\Models\SuratKeteranganUsaha;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsSuratKeteranganUsaha extends BaseWidget
{
    protected ?string $heading = 'Statistik Surat Keterangan Usaha';

    protected function getStats(): array
    {
        $totalSurat = SuratKeteranganUsaha::count();
        $suratHariIni = SuratKeteranganUsaha::whereDate('created_at', today())->count();
        $suratBulanIni = SuratKeteranganUsaha::whereMonth('created_at', Carbon::now()->month)->count();

        return [
            Stat::make('Total Surat Keterangan Usaha', $totalSurat)
                ->chart($this->getTotalSuratChartData())
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Surat Keterangan Usaha Hari Ini', $suratHariIni)
                ->chart($this->getSuratChartData())
                ->color('success'),

            Stat::make('Surat Keterangan Usaha Bulan Ini', $suratBulanIni)
                ->chart($this->getMonthlySuratChartData())
                ->color('info'),
        ];
    }

    protected function getTotalSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratKeteranganUsaha::whereDate('created_at', '<=', $date)->count();
        }
        return $chartData;
    }

    protected function getSuratChartData(): array
    {
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData[] = SuratKeteranganUsaha::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }

    protected function getMonthlySuratChartData(): array
    {
        $chartData = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $chartData[] = SuratKeteranganUsaha::whereDate('created_at', $date)->count();
        }
        return $chartData;
    }
}