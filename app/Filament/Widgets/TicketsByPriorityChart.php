<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Widgets\BarChartWidget;

class TicketsByPriorityChart extends BarChartWidget
{
    protected static ?string $heading = 'Tickets by Priority';

    protected function getData(): array
    {
        $data = Tickets::selectRaw('SLA, count(*) as count')
            ->groupBy('SLA')
            ->get();
            
        return [
            'labels' => $data->pluck('SLA'),
            'datasets' => [
                [
                    'label' => 'Tickets by Priority',
                    'data' => $data->pluck('count'),
                    'backgroundColor' => [
                        '#10b981', // emerald (low)
                        '#f59e0b', // amber (medium)
                        '#ef4444', // red (high)
                    ],
                ],
            ],
        ];
    }
}