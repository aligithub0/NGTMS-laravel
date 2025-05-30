<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Events\Auth\LoggedIn;
use Filament\Events\Auth\LoggedOut;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Track login events
    Event::listen(LoggedIn::class, function (LoggedIn $event) {
        ActivityLog::createLogEntry('User logged in via Filament');
    });

    // Track logout events
    Event::listen(LoggedOut::class, function (LoggedOut $event) {
        ActivityLog::createLogEntry('User logged out via Filament');
    });
    }
}
