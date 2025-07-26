<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratKelahiranExport;
use App\Exports\SuratKematianExport;
use App\Exports\SuratKeteranganUsahaExport;
use App\Exports\SuratPengantarIzinPerjamuanExport;
use App\Exports\SuratPengantarExport;
use App\Exports\AllSuratExport;

// Route::get('/main-panel-l', function () {
//     return view('welcome');
// });


Route::middleware(['auth'])->group(function () {
    Route::get('/export-month-kelahiran/{month}/{year}', function ($month, $year) {
        return Excel::download(new SuratKelahiranExport($month, $year), "data-$month-$year.xlsx");
    })->name('export.by-month-kelahiran');

    Route::get('/export-month-kematian/{month}/{year}', function ($month, $year) {
        return Excel::download(new SuratKematianExport($month, $year), "data-$month-$year.xlsx");
    })->name('export.by-month-kematian');

    Route::get('/export-month-keterangan-usaha/{month}/{year}', function ($month, $year) {
        return Excel::download(new SuratKeteranganUsahaExport($month, $year), "data-$month-$year.xlsx");
    })->name('export.by-month-keterangan-usaha');

    Route::get('/export-month-pengantar/{month}/{year}', function ($month, $year) {
        return Excel::download(new SuratPengantarExport($month, $year), "data-$month-$year.xlsx");
    })->name('export.by-month-pengantar');

    Route::get('/export-month-pengantar-izin-perjamuan/{month}/{year}', function ($month, $year) {
        return Excel::download(new SuratPengantarIzinPerjamuanExport($month, $year), "data-$month-$year.xlsx");
    })->name('export.by-month-pengantar-izin-perjamuan');

    Route::get('/export-all-surat/{month}/{year}', function ($month, $year) {
        return Excel::download(new AllSuratExport($month, $year), "all-surat-$month-$year.xlsx");
    })->name('export.all-surat');
});
