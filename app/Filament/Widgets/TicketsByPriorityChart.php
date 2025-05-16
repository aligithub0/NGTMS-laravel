<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Widgets\BarChartWidget;

class TicketsByPriorityChart extends BarChartWidget
{
    protected static ?string $heading = 'Tickets by Priority';

    protected function getData(): array
    {
        $data = Tickets::with('priority')
            ->selectRaw('priority_id, count(*) as count')
            ->groupBy('priority_id')
            ->orderBy('priority_id')
            ->get();
            
        return [
            'labels' => $data->pluck('priority.name'),
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
                'datalabels' => [ // 👈 Makes numbers appear on bars
                    'display' => true,
                    'color' => '#000',
                    'anchor' => 'center', // Positions label in middle of bar
                    'align' => 'center',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 14,
                    ],
                    'formatter' => (function($value) {
                        return $value; // Shows exact value
                    }),
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0, // Whole numbers only
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

    // Required to load the datalabels plugin
    protected function getPlugins(): array
    {
        return [
            'datalabels' => true, // 👈 Enables the plugin
        ];
    }
}