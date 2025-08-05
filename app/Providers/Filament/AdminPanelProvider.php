<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Widgets\Widget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Filament\Navigation\MenuItem;
use Filament\Pages\Dashboard as PagesDashboard;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandLogo(asset('images/brand-logo.svg'))
            ->brandLogoHeight('3.5rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                // ComplaintMap::class,
            ])
            ->collapsibleNavigationGroups(false)
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
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->plugins([
            //     FilamentEditProfilePlugin::make()
            //         ->setIcon('heroicon-o-user')
            //         ->shouldShowAvatarForm(
            //             value: true,
            //             directory: 'avatars', // image will be stored in 'storage/app/public/avatars
            //         )
            // ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Edit Profil')
                    ->url(fn(): string => EditProfile::getUrl())
                    ->icon('heroicon-m-user-circle')
            ])
            ->databaseNotifications();
    }

    // sidebar pembatas judul
    // public function registerNavigationGroups(): array
    // {
    //     return [
    //         NavigationGroup::make()
    //             ->label('App')
    //             ->icon('heroicon-o-home')
    //             ->collapsible(false),

    //         NavigationGroup::make()
    //             ->label('Sistem')
    //             ->icon('heroicon-o-cog-6-tooth')
    //             ->collapsible(false),
    //     ];
    // }
}
