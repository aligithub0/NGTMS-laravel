<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tickets', Tickets::count())
                ->description('All tickets')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('primary'),
                
            Stat::make('Open Tickets', Tickets::whereHas('ticketStatus', fn($q) => $q->where('name', 'initiated'))->count())
                ->description('Needs attention')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
                
            Stat::make('Assigned to You', Tickets::where('assigned_to_id', auth()->id())->count())
                ->description('Your workload')
                ->descriptionIcon('heroicon-o-user')
                ->color('success'),
                
            // Stat::make('Overdue Tickets', Tickets::where('resolution_time', '<', now())->count())
            //     ->description('Past resolution time')
            //     ->descriptionIcon('heroicon-o-clock')
            //     ->color('danger'),
        ];
    }
}