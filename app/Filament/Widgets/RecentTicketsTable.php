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
use App\Filament\Pages\EditTicket;
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
                
                // Ticket source filter
                SelectFilter::make('source')
                    ->relationship('ticketSource', 'name')
                    ->label('Ticket Source')
                    ->searchable()
                    ->preload(),
                
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
                
                // Quick status filters
                Filter::make('open_tickets')
                    ->label('Open Tickets Only')
                    ->query(fn (Builder $query): Builder => $query->whereHas('ticketStatus', fn ($q) => $q->where('name', 'Open')))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-s-pencil')
                    ->url(fn (Tickets $record): string => route('filament.admin.pages.edit-ticket', ['ticket' => $record])),
            ]);
    }
}