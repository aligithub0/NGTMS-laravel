<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Widgets\BarChartWidget;

class TicketsByPriorityChart extends BarChartWidget
{
    protected static ?string $heading = 'Tickets by Priority';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Tickets::selectRaw('SLA, count(*) as count')
            ->groupBy('SLA')
            ->orderBy('SLA')
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
                    'borderColor' => '#ffffff',
                    'borderWidth' => 1,
                    'borderRadius' => 6,
                    'barPercentage' => 0.7,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'drawBorder' => false,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}