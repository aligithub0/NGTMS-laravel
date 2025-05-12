<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentTimesheetsWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Timesheet::query()
            ->with(['users', 'project'])
            ->whereDate('created_at', today())
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('users.name')
                ->label('Employee'),
            TextColumn::make('project.name'),
            TextColumn::make('from_time')
                ->time(),
            TextColumn::make('to_time')
                ->time(),
            TextColumn::make('total_hours')
                ->label('Hours'),
        ];
    }
}