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
            $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('ticket_status_id', 3))->count(); //ticket opened
            $assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();
            $newTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('ticket_status_id', 2))->count();
            $overdueTickets = Tickets::whereNotNull('assigned_to_id')
                                ->whereHas('ticketStatus', fn($q) => $q->where('id', '8'))   //ticket closed
                                ->where('resolution_time', '>', now())
                                ->count();
            $inProgressTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 4))->count();
            $onHoldTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 5))->count();
            $reopenedTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 9))->count();
        } 
        // For Manager - show their tickets and their agents' tickets
        elseif ($user->hasRole('Manager')) {
            // Get the agents under this manager
            $agentIds = User::where('manager_id', $user->id)->pluck('id');
            
            $totalTickets = Tickets::where('assigned_to_id', $user->id)
                            ->orWhereIn('assigned_to_id', $agentIds)
                            ->count();
                            
            $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', '3'))
                            ->where(function($query) use ($user, $agentIds) {
                                $query->where('assigned_to_id', $user->id)
                                    ->orWhereIn('assigned_to_id', $agentIds);
                            })
                            ->count();
                            
            $assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();

            $newTickets = Tickets::whereNull('assigned_to_id')
                                  ->whereHas('ticketStatus', fn($q) => $q->where('ticket_status_id', 2))->count();
            
            $overdueTickets = Tickets::where(function($query) use ($user, $agentIds) {
                                    $query->where('assigned_to_id', $user->id)
                                        ->orWhereIn('assigned_to_id', $agentIds);
                                })
                                ->where('resolution_time', '>', now())
                                ->count();
                                
            $inProgressTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 4))
                                ->where(function($query) use ($user, $agentIds) {
                                    $query->where('assigned_to_id', $user->id)
                                        ->orWhereIn('assigned_to_id', $agentIds);
                                })
                                ->count();
                                
            $onHoldTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 5))
                            ->where(function($query) use ($user, $agentIds) {
                                $query->where('assigned_to_id', $user->id)
                                    ->orWhereIn('assigned_to_id', $agentIds);
                            })
                            ->count();
                            
            $reopenedTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 9))
                                ->where(function($query) use ($user, $agentIds) {
                                    $query->where('assigned_to_id', $user->id)
                                        ->orWhereIn('assigned_to_id', $agentIds);
                                })
                                ->count();
        } 
        // For regular users - only show their own tickets
        else {
            $totalTickets = Tickets::where('assigned_to_id', $user->id)->count();
            $openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', '3'))
                            ->where('assigned_to_id', $user->id)
                            ->count();
            $assignedTickets = $totalTickets; // For regular users, assigned tickets = total tickets
            $newTickets = Tickets::whereNull('assigned_to_id')
                              ->whereHas('ticketStatus', fn($q) => $q->where('ticket_status_id', 2))->count();
            $overdueTickets = Tickets::where('assigned_to_id', $user->id)
                                ->where('resolution_time', '>', now())
                                ->count();
            $inProgressTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 4))
                                ->where('assigned_to_id', $user->id)
                                ->count();
            $onHoldTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 5))
                            ->where('assigned_to_id', $user->id)
                            ->count();
            $reopenedTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 9))
                                ->where('assigned_to_id', $user->id)
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

            Stat::make('New Tickets', $newTickets)
                ->description('Unassigned new tickets')
                ->descriptionIcon('heroicon-o-sparkles')
                ->color('info')
                ->chart($this->getChartData('new'))
                ->chartColor('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-cyan-100 bg-gradient-to-br from-cyan-50 to-white',
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

            // Second row of stats
            Stat::make('Overdue Tickets', $overdueTickets)
                ->description('Past resolution time')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger')
                ->chart($this->getChartData('overdue'))
                ->chartColor('danger')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-red-100 bg-gradient-to-br from-red-50 to-white',
                ]),
                
            Stat::make('In Progress', $inProgressTickets)
                ->description('Active troubleshooting')
                ->descriptionIcon('heroicon-o-cog')
                ->color('indigo')
                ->chart($this->getChartData('in_progress'))
                ->chartColor('indigo')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white',
                ]),
                
            Stat::make('On Hold', $onHoldTickets)
                ->description('Awaiting confirmation')
                ->descriptionIcon('heroicon-o-pause')
                ->color('gray')
                ->chart($this->getChartData('on_hold'))
                ->chartColor('gray')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-white',
                ]),
                
            Stat::make('Reopened', $reopenedTickets)
                ->description('Issues that reappeared')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('rose')
                ->chart($this->getChartData('reopened'))
                ->chartColor('rose')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition-shadow rounded-xl border border-rose-100 bg-gradient-to-br from-rose-50 to-white',
                ])
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
            case 'new':
                return [3, 2, 4, 5, 3, 2, 4, 3, 5, 4, 3, 2];
            case 'in_progress':
                return [2, 3, 4, 3, 5, 4, 6, 5, 7, 6, 5, 4];
            case 'on_hold':
                return [1, 2, 1, 3, 2, 1, 2, 3, 2, 1, 2, 3];
            case 'reopened':
                return [0, 1, 0, 2, 1, 0, 1, 2, 1, 0, 1, 2];
            default: // total
                return [10, 12, 15, 18, 20, 22, 25, 28, 26, 30, 28, 32];
        }
    }

    protected function getColumns(): int
    {
        return 4; // Set the number of columns to 4 for each row
    }
}