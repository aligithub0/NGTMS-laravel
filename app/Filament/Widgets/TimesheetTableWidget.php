<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TimesheetTableWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Timesheet::query()
                ->with(['users', 'project', 'ts_status'])
                ->latest()
                ->limit(10))
            ->columns([
                TextColumn::make('users.name')
                    ->label('Employee'),
                TextColumn::make('project.name')
                    ->label('Project'),
                TextColumn::make('from_time')
                    ->time(),
                TextColumn::make('to_time')
                    ->time(),
                TextColumn::make('total_hours')
                    ->label('Hours'),
                TextColumn::make('ts_status.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Pending' => 'warning',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}