<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketJourneyResource\Pages;
use App\Filament\Resources\TicketJourneyResource\RelationManagers;
use App\Models\TicketJourney;
use App\Models\Tickets;
use App\Models\User;
use App\Models\TicketStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;

class TicketJourneyResource extends Resource
{
    protected static ?string $model = TicketJourney::class;

    protected static ?string $navigationIcon = 'heroicon-s-ticket';  
    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
    }
    
    public static function getNavigationGroup(): ?string
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getNavigationGroupByFilename($currentFile);
    }

    public static function canViewAny(): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

public static function canCreate(): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

public static function canEdit($record): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

public static function canDelete($record): bool
{
    return auth()->user()?->role?->name === 'Admin';
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ticket_id')
                ->label('Tickets')
                ->options(Tickets::all()->pluck('title', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                Select::make('from_agent')
                ->label('From User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),
                
                Select::make('to_agent')
                ->label('To User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                Select::make('from_status')
                ->label('From Status')
                ->options(TicketStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                Select::make('to_status')
                ->label('To Status')
                ->options(TicketStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                Select::make('actioned_by')
                ->label('Actioned By')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket.title')->searchable()->label('Ticket'),
                TextColumn::make('fromAgent.name')->searchable()->label('From User'),
                TextColumn::make('toAgent.name')->searchable()->label('To User'),
                TextColumn::make('fromStatus.name')->searchable()->label('From Status'),
                TextColumn::make('toStatus.name')->searchable()->label('To Status'),
                TextColumn::make('actionedBy.name')->searchable()->label('Actioned By'),
                TextColumn::make('logged_time')->searchable()->label('Logged Time'),
                TextColumn::make('total_time_diff')->searchable()->label('Time Difference'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicketJourneys::route('/'),
            'create' => Pages\CreateTicketJourney::route('/create'),
            'edit' => Pages\EditTicketJourney::route('/{record}/edit'),
        ];
    }
}
