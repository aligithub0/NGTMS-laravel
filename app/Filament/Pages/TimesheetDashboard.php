<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RecentTimesheetsWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TimesheetHoursChart;
use App\Filament\Widgets\TimesheetTableWidget;
use Filament\Pages\Page;

class TimesheetDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-clock';
    
    protected static string $view = 'filament.pages.timesheet-dashboard';
    
    protected static ?string $navigationLabel = 'Timesheet Dashboard';
    
    protected static ?string $title = 'Timesheet Overview';
    
    protected static ?string $navigationGroup = 'Reports';
    
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            TimesheetTableWidget::class,
            TimesheetHoursChart::class,
        ];
    }
    
    protected function getFooterWidgets(): array
    {
        return [
            RecentTimesheetsWidget::class,
        ];
    }
}