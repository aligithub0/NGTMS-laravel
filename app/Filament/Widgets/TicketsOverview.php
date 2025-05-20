<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        // For Admin - show all tickets
        if ($user->hasRole('Admin')) {
            $totalTickets = Tickets::count();
            $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', '3'))->count(); //ticket opened
            $assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();
            $overdueTickets = Tickets::where('assigned_to_id')
                             ->whereHas('ticketStatus', fn($q) => $q->where('id', '8'))   //ticket closed
                                ->where('resolution_time', '<', now())
                                ->count();
        } 
        // For Manager - show their tickets and their agents' tickets
        elseif ($user->hasRole('Manager')) {
            // Get the agents under this manager
            $agentIds = User::where('manager_id', $user->id)->pluck('id');
            
            $totalTickets = Tickets::where('assigned_to_id', $user->id)
                            ->orWhereIn('assigned_to_id', $agentIds)
                            ->count();
                            
            $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('name', 'initiated'))
                            ->where(function($query) use ($user, $agentIds) {
                                $query->where('assigned_to_id', $user->id)
                                    ->orWhereIn('assigned_to_id', $agentIds);
                            })
                            ->count();
                            
            $assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();
            
            $overdueTickets = Tickets::where('assigned_to_id', $user->id)
                                ->orWhereIn('assigned_to_id', $agentIds)
                                ->where('resolution_time', '<', now())
                                ->count();
        } 
            // For regular users - only show their own tickets
            else {
                $totalTickets = Tickets::where('assigned_to_id', $user->id)->count();
                $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('name', 'initiated'))
                                ->where('assigned_to_id', $user->id)
                                ->count();
                $assignedTickets = $totalTickets; // For regular users, assigned tickets = total tickets
                $overdueTickets = Tickets::where('assigned_to_id', $user->id)
                                    ->where('resolution_time', '<', now())
                                    ->count();
            }
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

            Stat::make('Overdue Tickets', $overdueTickets)
                ->description('Past resolution time')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger')
                ->chart($this->getChartData('overdue'))
                ->chartColor('danger')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-red-100 bg-gradient-to-br from-red-50 to-white',
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
            case 'overdue':
                return [0, 1, 0, 2, 1, 3, 2, 4, 3, 2, 1, 3];
            default: // total
                return [10, 12, 15, 18, 20, 22, 25, 28, 26, 30, 28, 32];
        }
    }
}