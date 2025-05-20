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
use App\Models\Priority;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;




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

//     public static function canViewAny(): bool
// {
//     return auth()->user()?->role?->name === 'Admin';
// }

 public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->name === 'Admin';
    }


     public static function canView($record): bool
    {
        $user = auth()->user();
        
        // Admin can view all tickets
        if ($user->role->name === 'Admin') {
            return true;
        }
        
        // User can view tickets assigned to them or created by them
        return $record->assigned_to_id === $user->id || 
               $record->created_by_id === $user->id;
    }

    // Custom logic for editing tickets
    public static function canEdit($record): bool
    {
        $user = auth()->user();
        
        // Admin can edit all tickets
        if ($user->role->name === 'Admin') {
            return true;
        }
        
        // User can edit tickets assigned to them
        return $record->assigned_to_id === $user->id || $record->created_by_id === $user->id;
    }

public static function canCreate(): bool
{
    return auth()->user()?->role?->name === 'Admin';
}

// public static function canEdit($record): bool
// {
//     return auth()->user()?->role?->name === 'Admin';
// }

public static function canDelete($record): bool
{
    return auth()->user()?->role?->name === 'Admin';
}


    protected static ?string $navigationIcon = 'heroicon-s-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('priority_id')
                ->label('Priority')
                ->options(Priority::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                TextInput::make('title')->required()->maxLength(255),

                Textarea::make('description')->required()->rows(2),

                
                TextInput::make('requested_email')
                ->required()
                ->email()
                ->rules(['email', 'required', 'max:255'])->label('Requested Email'),    


                RichEditor::make('message')
                ->required()
                ->columnSpanFull(),

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

                
                Select::make('ticket_source_id')
                ->label('Ticket Source')
                ->options(TicketSource::all()->pluck('name', 'id'))
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

                TextInput::make('contact_id')->numeric()->nullable(),
                Select::make('SLA')
                ->label('SLA')
                ->options(SlaConfiguration::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                TextInput::make('contact_ref_no')->nullable(),

                
                Select::make('company_id')
                ->label('Company')
                ->options(Company::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


          
                Select::make('response_time_id')
                ->label('Response Time')
                ->options(SlaConfiguration::all()->pluck('response_time', 'id'))
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $sla = SlaConfiguration::find($state);
                    if ($sla) {
                        $set('response_time', $sla->response_time); 
                    }
                }),
            
            Hidden::make('response_time')
                ->dehydrated()
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

                TagsInput::make('cc_recipients')->label('CC Recipents')
                ->required(),

             Select::make('resolution_time_id')
                ->label('Resolution Time')
                ->options(SlaConfiguration::all()->pluck('resolution_time', 'id'))
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $sla = SlaConfiguration::find($state);
                    if ($sla) {
                        $set('resolution_time', $sla->resolution_time); 
                    }
                }),
            
            Hidden::make('resolution_time')
                ->dehydrated()
                ->required(),


                TagsInput::make('to_recipients')->label('To Recipents')
                    ->required(),

               
               

                Toggle::make('reminder_flag')
                ->label('Reminder Flag')
                ->default(false)
                ->inline(false),

                DateTimePicker::make('reminder_datetime')
                ->nullable()
                ->required(),

                Textarea::make('internal_note')->required()->rows(2)->label('Internal Note'),
                
                Textarea::make('external_note')->required()->rows(2)->label('External Note'),   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('priority.name')->searchable()->label('Priority'),
                TextColumn::make('title')->searchable()->label('Title'),
                TextColumn::make('description')->searchable()->label('Description')->limit(30),
                TextColumn::make('requested_email')->searchable()->label('Requested Email'),
                TextColumn::make('TicketStatus.name')->searchable()->label('Ticket Status'),
                TextColumn::make('createdBy.name')->searchable()->label('Created By'),
                TextColumn::make('assignedTo.name')->searchable()->label('Assigned To'),
                TextColumn::make('TicketSource.name')->searchable()->label('Ticket Source'),
                TextColumn::make('contact_id')->searchable()->label('Contact ID'),
                TextColumn::make('contact_ref_no')->searchable()->label('Contact Ref No'),
                TextColumn::make('slaConfiguration.name')->searchable()->label('SLA'),
                TextColumn::make('to_recipients')->searchable()->label('To Recipents'),
                TextColumn::make('cc_recipients')->searchable()->label('CC Recipents'),
                TextColumn::make('response_time')->searchable()->label('Response Time'),
                TextColumn::make('resolution_time')->searchable()->label('Resolution Time'),
                
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
            'view' => Pages\ViewTicket::route('/{record}'),
            // 'edit-ticket' => Filament\Pages\EditTicket::route('/{record}/edit-ticket')
        ];
    }
}
