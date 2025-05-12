<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Calculate total hours for the current week
        $weeklyHours = Timesheet::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->sum(function ($timesheet) {
                return $this->convertTimeToHours($timesheet->total_time_consumed);
            });

        return [
            Stat::make('Total Hours This Week', number_format($weeklyHours, 2) . ' hrs')
                ->description('7% increase from last week')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Pending Approvals', 
                Timesheet::whereHas('ts_status', fn($query) => $query->where('name', 'Pending'))->count())
                ->description('3 new since yesterday')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
                
            Stat::make('Most Active Project', 
                Timesheet::with('project')
                    ->select('project_id')
                    ->selectRaw('count(*) as count')
                    ->groupBy('project_id')
                    ->orderBy('count', 'desc')
                    ->first()?->project?->name ?? 'N/A')
                ->description('Highest hours logged')
                ->descriptionIcon('heroicon-m-chart-bar'),
        ];
    }

    protected function convertTimeToHours($timeString): float
    {
        if (empty($timeString)) {
            return 0;
        }

        $parts = explode(':', $timeString);
        $hours = (int)$parts[0];
        $minutes = (int)($parts[1] ?? 0);
        
        return $hours + ($minutes / 60);
    }
}