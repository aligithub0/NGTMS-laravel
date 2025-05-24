<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Tickets;
use Illuminate\Support\Facades\Route;

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
        Route::bind('record', function ($value) {
        return Tickets::with([  // Eager load relationships
            'ticketStatus',
            'priority',
            'createdBy',
            'assignedTo'
        ])->findOrFail($value);
    });
    }
}
