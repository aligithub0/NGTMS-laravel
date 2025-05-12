<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;

class TimesheetHoursChart extends LineChartWidget
{
    protected static ?string $heading = 'Weekly Hours Logged';

    protected function getData(): array
    {
        $data = Trend::model(Timesheet::class)
            ->between(
                start: now()->subWeeks(4),
                end: now(),
            )
            ->perWeek()
            ->sum('total_time_consumed');

        return [
            'datasets' => [
                [
                    'label' => 'Hours logged',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}