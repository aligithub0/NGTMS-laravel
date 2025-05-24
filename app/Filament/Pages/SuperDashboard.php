<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SuperDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-home';
    protected static string $view = 'filament.pages.super-dashboard';
    protected static ?string $navigationLabel = 'Super Dashboard';
    protected static ?string $title = 'Super Dashboard';
    protected static ?string $navigationGroup = 'Dashboard';

    // Optional: restrict access by role
    public static function canAccess(): bool
    {
        $roleName = auth()->user()?->role?->name ?? null;
        return in_array($roleName, ['Admin']);
    }
}
