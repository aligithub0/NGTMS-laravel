<?php

namespace App\Filament\Widgets;

use App\Models\Tickets;
use App\Models\TicketStatus;
use App\Models\TicketSource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use App\Filament\Resources\TicketsResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DatePicker;
use App\Filament\Pages\TicketReply;

class RecentTicketsTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();
        $query = Tickets::query()->with([
            'ticketStatus',
            'priority',
            'createdBy',
            'assignedUser',
            'slaConfiguration',
            'ticketSource'
        ])->latest();
        
        if ($user->hasRole('Admin')) {
            return $query;
        }
        
        if ($user->hasRole('Manager') || $user->isManager()) {
            $agentIds = $user->agents()->pluck('id');
            return $query->where(function($q) use ($user, $agentIds) {
                $q->whereIn('assigned_to_id', $agentIds)
                  ->orWhere('assigned_to_id', $user->id);
            });
        }
        
        return $query->where('assigned_to_id', $user->id);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery()->limit(10))
            ->columns([
                TextColumn::make('ticket_id')
                    ->label('Ticket ID')
                    ->searchable()
                    ->sortable()
                    ->url(function (Tickets $record): string {
                        return TicketsResource::getUrl('view', ['record' => $record]);
                    })
                    ->color('primary'),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
                
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('slaConfiguration.name')
                    ->label('SLA')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('priority.name')
                    ->label('Priority')
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            'High' => 'danger',
                            'Medium' => 'warning',
                            'Low' => 'success',
                            default => 'gray',
                        };
                    })
                    ->sortable(),
                    
                TextColumn::make('ticketStatus.name')
                    ->label('Status')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Draft' => 'gray',
                            'Created' => 'success',
                            'Assigned' => 'info',
                            'Inprogress' => 'warning',
                            'Waiting' => 'warning',
                            'Approval' => 'primary',
                            'Closed' => 'danger',
                            default => 'gray',
                        };
                    })
                    ->sortable(),
                    
                TextColumn::make('assignedUser.name') 
                    ->label('Assigned To')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->label('Created On')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        try {
                            return \Carbon\Carbon::parse($state)->format(config('constants.default_datetime_format'));
                        } catch (\Exception $e) {
                            return 'Invalid date';
                        }
                    }),
                    
                TextColumn::make('resolution_time')
                    ->label('Due Date')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        try {
                            return \Carbon\Carbon::parse($state)->format(config('constants.default_datetime_format'));
                        } catch (\Exception $e) {
                            return 'Invalid date';
                        }
                    })
                    ->color(function ($state) {
                        if (\Carbon\Carbon::parse($state)->isPast()) {
                            return 'danger';
                        }
                        return null;
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->relationship('ticketStatus', 'name')
                    ->label('Ticket Status')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('source')
                    ->relationship('ticketSource', 'name')
                    ->label('Ticket Source')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('sla')
                    ->relationship('slaConfiguration', 'name')
                    ->label('SLA Configuration'),
                    
                SelectFilter::make('priority')
                    ->relationship('priority', 'name')
                    ->label('Ticket Priority'),
                
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('From Date'),
                        DatePicker::make('created_until')
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
                
                Filter::make('open_tickets')
                    ->label('Open Tickets Only')
                    ->query(fn (Builder $query): Builder => $query->whereHas('ticketStatus', fn ($q) => $q->whereNotIn('name', ['Closed', 'Resolved'])))
                    ->toggle(),
                ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->icon('heroicon-s-pencil')
                    ->url(fn (Tickets $record): string => TicketsResource::getUrl('edit', ['record' => $record])),
                    
                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->icon('heroicon-s-eye')
                    ->url(fn (Tickets $record): string => TicketsResource::getUrl('view', ['record' => $record])),
                    
                Tables\Actions\Action::make('reply')
                ->label('')
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->url(fn (Tickets $record): string => TicketsResource::getUrl('reply', ['record' => $record]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}