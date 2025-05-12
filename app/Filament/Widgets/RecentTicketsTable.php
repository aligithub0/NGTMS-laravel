<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\TicketsResource;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTicketsTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Tickets::query()->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('ticketStatus.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'danger',
                        'In Progress' => 'warning',
                        'Resolved' => 'success',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assigned To'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('resolution_time')
                    ->label('Due Date')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Tickets $record): string => TicketsResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}