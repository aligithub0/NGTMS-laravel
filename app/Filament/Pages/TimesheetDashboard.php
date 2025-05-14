<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RecentTimesheetsWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TimesheetHoursChart;
use App\Filament\Widgets\TimesheetTableWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Page;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class TimesheetDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-clock';
    
    protected static string $view = 'filament.pages.timesheet-dashboard';
    
    protected static ?string $navigationLabel = 'Timesheet Dashboard';
    
    protected static ?string $title = 'Timesheet Overview';
    
    protected static ?string $navigationGroup = 'Reports';


    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate'),
                        DatePicker::make('endDate'),
                        // ...
                    ])
                    ->columns(3),
            ]);
    }
    
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