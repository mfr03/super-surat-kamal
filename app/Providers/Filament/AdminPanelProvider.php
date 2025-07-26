<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\ExportAllPage;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Filament\Resources\SuratKelahiranResource\Widgets\StatsSuratKelahiran;
use App\Filament\Resources\SuratKematianResource\Widgets\StatsSuratKematian;
use App\Filament\Resources\SuratKeteranganUsahaResource\Widgets\StatsSuratKeteranganUsaha;
use App\Filament\Resources\SuratPengantarIzinPerjamuanResource\Widgets\StatsSuratPengantarIzinPerjamuan;
use App\Filament\Resources\SuratPengantarResource\Widgets\StatsSuratPengantar;
use App\Filament\Widgets\ExportAllByMonthAction;
use App\Filament\Widgets\ExportAllWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->brandName('Sistem Surat Desa Kamal v.2.0')
            ->favicon(asset('logo-skh.png'))
            ->login()
            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                ExportAllPage::class,
            ])
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                    shouldRegisterUserMenu: true,
                    userMenuLabel: 'My Profile',
                    shouldRegisterNavigation: false, 
                    navigationGroup: 'Settings',
                    hasAvatars: false, 
                    slug: 'my-profile'
                )
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
