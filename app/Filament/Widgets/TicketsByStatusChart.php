<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use App\Models\TicketStatus;
use Filament\Widgets\PieChartWidget;

class TicketsByStatusChart extends PieChartWidget
{
    protected static ?string $heading = 'Tickets by Status';

    protected function getData(): array
    {
        // Alternative query if you can't modify TicketStatus model
        $statusCounts = TicketStatus::query()
            ->leftJoin('tickets', 'ticket_statuses.id', '=', 'tickets.ticket_status_id')
            ->selectRaw('ticket_statuses.name, count(tickets.id) as tickets_count')
            ->groupBy('ticket_statuses.id', 'ticket_statuses.name')
            ->get();

        return [
            'labels' => $statusCounts->pluck('name'),
            'datasets' => [
                [
                    'label' => 'Tickets by Status',
                    'data' => $statusCounts->pluck('tickets_count'),
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#ef4444', // red
                        '#f59e0b', // amber
                        '#10b981', // emerald
                        '#8b5cf6', // violet
                    ],
                    'borderColor' => '#ffffff',
                ],
            ],
        ];
    }
}