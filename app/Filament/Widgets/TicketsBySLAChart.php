<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Widgets\BarChartWidget;

class TicketsBySLAChart extends BarChartWidget
{
    protected static ?string $heading = 'Tickets by SLA';
    // protected static ?string $maxHeight = '400px';

    
    protected function getData(): array
    {
        $data = Tickets::with('slaConfiguration')
            ->selectRaw('SLA, count(*) as count')
            ->groupBy('SLA')
            ->orderBy('SLA')
            ->get();
            
        return [
            'labels' => $data->pluck('slaConfiguration.name'), // Assuming SlaConfiguration has 'name' field
            'datasets' => [
                [
                    'label' => 'Tickets by SLA',
                    'data' => $data->pluck('count'),
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#6366f1', // indigo
                        '#10b981', // emerald (low priority)
                        '#f59e0b', // amber (medium priority)
                        '#ef4444', // red (high priority)
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
                    'callbacks' => [
                        'label' => 'function(context) {
                            return context.parsed.y + " tickets";
                        }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'precision' => 0, // Ensure whole numbers on Y axis
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