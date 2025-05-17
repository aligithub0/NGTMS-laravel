<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use App\Models\TicketStatus;
use App\Models\TicketSource;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Company;
use App\Models\Purpose;
use App\Models\SlaConfiguration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms;
use App\Filament\Resources\TicketsResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;

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
            ->filters([
    // Status filter
    SelectFilter::make('status')
        ->relationship('ticketStatus', 'name')
        ->label('Ticket Status')
        ->multiple()
        ->searchable()
        ->preload(),
    
    // Assigned to filter
    // SelectFilter::make('assigned_to')
    //     ->relationship('assignedTo', 'name')
    //     ->label('Assigned To')
    //     ->searchable()
    //     ->multiple()
    //     ->preload(),
    
    // Created by filter
    // SelectFilter::make('created_by')
    //     ->relationship('createdBy', 'name')
    //     ->label('Created By')
    //     ->searchable()
    //     ->multiple()
    //     ->preload(),
    
    // Ticket source filter
    SelectFilter::make('source')
        ->relationship('ticketSource', 'name')
        ->label('Ticket Source')
        ->searchable()
        ->preload(),
    
    // Company filter
    // SelectFilter::make('company')
    //     ->relationship('company', 'name')
    //     ->label('Company')
    //     ->searchable()
    //     ->multiple()
    //     ->preload(),
    
    // SLA filter
    // SelectFilter::make('sla')
    //     ->relationship('slaConfiguration', 'name')
    //     ->label('SLA Configuration')
    //     ->searchable()
    //     ->preload(),
    
    // Purpose type filter (for array field) - corrected
    // SelectFilter::make('purpose_type')
    //     ->label('Purpose Type')
    //     ->options(Purpose::pluck('name', 'id'))
    //     ->query(function (Builder $query, array $data): Builder {
    //         if (!empty($data['values'])) {
    //             return $query->where(function($query) use ($data) {
    //                 foreach ($data['values'] as $value) {
    //                     $query->orWhereJsonContains('purpose_type_id', $value);
    //                 }
    //             });
    //         }
    //         return $query;
    //     })
    //     ->multiple()
    //     ->searchable(),
    
    // Date range filter
    Filter::make('created_at')
        ->form([
            Forms\Components\DatePicker::make('created_from')
                ->label('From Date'),
            Forms\Components\DatePicker::make('created_until')
                ->label('To Date'),
        ])
        ->query(function (Builder $query, array $data): Builder {
            return $query
                ->when(
                    $data['created_from'] ?? null,
                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                )
                ->when(
                    $data['created_until'] ?? null,
                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                );
        }),
    
    // Reminder flag filter
    // TernaryFilter::make('reminder_flag')
    //     ->label('Has Reminder')
    //     ->trueLabel('With reminder')
    //     ->falseLabel('Without reminder')
    //     ->nullable(),
    
    // Overdue tickets filter
    // Filter::make('overdue')
    //     ->label('Overdue Tickets')
    //     ->query(fn (Builder $query): Builder => $query->where('resolution_time', '<', now())
    //         ->whereHas('ticketStatus', fn ($q) => $q->where('name', '!=', 'Resolved'))),
    
    // Quick status filters
    Filter::make('open_tickets')
        ->label('Open Tickets Only')
        ->query(fn (Builder $query): Builder => $query->whereHas('ticketStatus', fn ($q) => $q->where('name', 'Open')))
        ->toggle(),
],)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Edit')
                    ->icon('heroicon-s-pencil')
                    ->url(fn (Tickets $record): string => TicketsResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}