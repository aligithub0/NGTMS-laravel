<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use App\Models\TicketStatus;
use Filament\Widgets\PieChartWidget;

class TicketsByStatusChart extends PieChartWidget
{
    protected static ?string $heading = 'Tickets by Status';
    // protected static ?string $maxHeight = '400px';

    
    protected function getData(): array
    {
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
                    'borderWidth' => 2,
                    'hoverOffset' => 10,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 20,
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'cutout' => '65%',
            'maintainAspectRatio' => false,
        ];
    }
}