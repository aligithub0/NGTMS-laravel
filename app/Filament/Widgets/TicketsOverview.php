<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTickets = Tickets::count();
        $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('name', 'initiated'))->count();
        $assignedTickets = Tickets::where('assigned_to_id', auth()->id())->count();

        return [
            Stat::make('Total Tickets', $totalTickets)
                ->description('All tickets in the system')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('primary')
                ->chart($this->getChartData('total'))
                ->chartColor('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-gray-100 bg-gradient-to-br from-blue-50 to-white',
                ]),
                
            Stat::make('Open Tickets', $openTickets)
                ->description('Requiring immediate attention')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning')
                ->chart($this->getChartData('open'))
                ->chartColor('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white',
                ]),
                
            Stat::make('Assigned to Me', $assignedTickets)
                ->description('Your current workload')
                ->descriptionIcon('heroicon-o-user-circle')
                ->color('success')
                ->chart($this->getChartData('assigned'))
                ->chartColor('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white',
                ]),

                Stat::make('Assigned to Me', $assignedTickets)
                ->description('Your current workload')
                ->descriptionIcon('heroicon-o-user-circle')
                ->color('success')
                ->chart($this->getChartData('assigned'))
                ->chartColor('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white',
                ]),
        ];
    }

    protected function getChartData(string $type): array
    {
        // Add more realistic sample data
        switch ($type) {
            case 'open':
                return [2, 3, 5, 7, 6, 8, 10, 12, 9, 11, 8, 10];
            case 'assigned':
                return [1, 2, 1, 3, 2, 4, 3, 5, 4, 3, 2, 4];
            default: // total
                return [10, 12, 15, 18, 20, 22, 25, 28, 26, 30, 28, 32];
        }
    }
}