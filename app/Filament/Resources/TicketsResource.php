<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\TicketsResource\Pages;
use App\Filament\Resources\TicketsResource\RelationManagers;
use App\Models\Tickets;
use App\Models\TicketStatus;
use App\Models\User;
use App\Models\TicketSource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use App\Models\Purpose;
use App\Models\SlaConfiguration;
use App\Models\NotificationType;
use App\Models\Company;
use Filament\Forms\Components\DateTimePicker;



class TicketsResource extends Resource
{
    protected static ?string $model = Tickets::class;

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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->maxLength(255),

                Textarea::make('description')->required()->rows(2),

                Textarea::make('internal_note')->required()->rows(2)->label('Internal Note'),
                
                Textarea::make('external_note')->required()->rows(2)->label('External Note'),

                Select::make('ticket_status_id')
                ->label('Ticket Status')
                ->options(TicketStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('created_by_id')
                ->label('Created By')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('assigned_to_id')
                ->label('Assigned To')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('ticket_source_id')
                ->label('Ticket Source')
                ->options(TicketSource::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                TextInput::make('contact_id')->numeric()->nullable(),

                TextInput::make('contact_ref_no')->nullable(),

                
                Select::make('purpose_type_id')
                ->label('Purpose Type')
                ->options(Purpose::all()->pluck('name', 'id'))
                ->multiple()
                ->searchable()
                ->preload()
                ->required()
                ->afterStateHydrated(function ($component, $state) {
                    if (is_string($state)) {
                        $component->state(json_decode($state, true));
                    }
                })
                ->dehydrateStateUsing(fn ($state) => json_encode($state))
                ->suffixAction(
                    Action::make('selectAllPurpose')
                        ->label('Select All')
                        ->icon('heroicon-m-check')
                        ->action(function ($component) {
                            $component->state(
                                Purpose::all()->pluck('id')->toArray()
                            );
                        })
                ),


                Select::make('SLA')
                ->label('SLA')
                ->options(SlaConfiguration::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                TextInput::make('resolution_time')
                ->nullable()
                ->required(),


                TextInput::make('response_time')
                ->nullable()
                ->required(),


                Select::make('notification_type_id')
                ->label('Notification Type')
                ->options(NotificationType::all()->pluck('name', 'id'))
                ->multiple()
                ->searchable()
                ->preload()
                ->required()
                ->afterStateHydrated(function ($component, $state) {
                    if (is_string($state)) {
                        $component->state(json_decode($state, true));
                    }
                })
                ->dehydrateStateUsing(fn ($state) => json_encode($state))
                ->suffixAction(
                    Action::make('selectAllNotificationType')
                        ->label('Select All')
                        ->icon('heroicon-m-check')
                        ->action(function ($component) {
                            $component->state(
                                NotificationType::all()->pluck('id')->toArray()
                            );
                        })
                ),

                Select::make('company_id')
                ->label('Company')
                ->options(Company::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Toggle::make('reminder_flag')
                ->label('Reminder Flag')
                ->default(false)
                ->inline(false),

                DateTimePicker::make('reminder_datetime')
                ->nullable()
                ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->label('Title'),
                TextColumn::make('description')->searchable()->label('Description')->limit(30),
                TextColumn::make('TicketStatus.name')->searchable()->label('Ticket Status'),
                TextColumn::make('createdBy.name')->searchable()->label('Created By'),
                TextColumn::make('assignedTo.name')->searchable()->label('Assigned To'),
                TextColumn::make('TicketSource.name')->searchable()->label('Ticket Source'),
                TextColumn::make('contact_id')->searchable()->label('Contact ID'),
                TextColumn::make('contact_ref_no')->searchable()->label('Contact Ref No'),
                TextColumn::make('slaConfiguration.name')->searchable()->label('SLA'),
                TextColumn::make('resolution_time')->searchable()->label('Resolution Time'),
                TextColumn::make('response_time')->searchable()->label('Response Time'),
                
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTickets::route('/create'),
            'edit' => Pages\EditTickets::route('/{record}/edit'),
        ];
    }
}
