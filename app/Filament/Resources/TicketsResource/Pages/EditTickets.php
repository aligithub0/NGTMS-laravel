<?php

namespace App\Filament\Resources\TicketsResource\Pages;

use App\Filament\Resources\TicketsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use App\Models\Purpose;
use App\Models\TicketStatus;
use App\Models\TicketSource;
use App\Models\Priority;
use App\Models\Contacts;
use App\Models\User;
use App\Models\NotificationType;
use App\Models\SlaConfiguration;
use App\Models\Tickets; // Add this import

class EditTickets extends EditRecord
{
    protected static string $resource = TicketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the ticket model
        $ticket = Tickets::find($data['id']);
        
        // If ticket exists and has a contact, pre-fill the contact information
        if ($ticket && $ticket->contact) {
            $data['contact_id'] = $ticket->contact_id;
            $data['contact_ref_no'] = $ticket->contact_ref_no;
            $data['requested_email'] = $ticket->requested_email;
            
            // Assuming these are stored as JSON in the database
            $data['to_recipients'] = $ticket->to_recipients ? json_decode($ticket->to_recipients, true) : [];
            $data['cc_recipients'] = $ticket->cc_recipients ? json_decode($ticket->cc_recipients, true) : [];
        }
        
        return $data;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        // Left Column
                        Grid::make()
                            ->schema([
                                Section::make('Ticket Details')
                                    ->schema([
                                        Select::make('purpose_type_id')
                                            ->label('Purpose')
                                            ->options(Purpose::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                           
                                            ->dehydrateStateUsing(fn ($state) => $state),
                                            
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        RichEditor::make('message')
                                            ->required()
                                            ->columnSpanFull(),
                                            
                                        Select::make('ticket_status_id')
                                            ->options(TicketStatus::all()->pluck('name', 'id'))
                                            ->required(),
                                            
                                        Select::make('ticket_source_id')
                                            ->options(TicketSource::all()->pluck('name', 'id'))
                                            ->required(),

                                        Select::make('priority_id')
                                            ->options(Priority::all()->pluck('name', 'id'))
                                            ->required(),
                                            
                                         Select::make('assigned_to_id')
                                            ->label('Assigned To')
                                            ->options(function () {
                                                $authUser = auth()->user();
                                                
                                                // Start with current user (always included)
                                                $usersQuery = User::where('id', $authUser->id);
                                                
                                                // If current user can assign to others, include other assignable users from same company
                                                if ($authUser->assigned_to_others) {
                                                    $usersQuery->orWhere(function ($query) use ($authUser) {
                                                        $query->where('company_id', $authUser->company_id)
                                                            // ->where('assigned_to_others', true)
                                                            ->where('id', '!=', $authUser->id) // Exclude current user (already included)
                                                            ->whereHas('status', function($query) {
                                                                $query->where('name', 'Active');
                                                            });
                                                    });
                                                }
                                                
                                                $users = $usersQuery->orderBy('name')->get();
                                                
                                                return $users->mapWithKeys(function ($user) use ($authUser) {
                                                    return [
                                                        $user->id => $user->id === $authUser->id 
                                                            ? $user->name . ' (Me)' 
                                                            : $user->name
                                                    ];
                                                });
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->default(auth()->id()) // Default to current user
                                            ->required()
                                            ->rules(['required', 'integer', 'exists:users,id']),

                                        Select::make('notification_type_id')
                                            ->options(NotificationType::all()->pluck('name', 'id'))
                                            ->multiple()
                                            ->required()
                                            ->afterStateHydrated(function ($component, $state) {
                                                if (is_string($state)) {
                                                    $component->state(json_decode($state, true));
                                                }
                                            })
                                            ->dehydrateStateUsing(fn ($state) => json_encode($state)),
                                    ])->compact(),
                            ])->columnSpan(['lg' => 1]),
                            
                        // Right Column
                        Grid::make()
                            ->schema([
                                Section::make('Contact Information')
                                    ->schema([
                                        Select::make('contact_id')
                                        ->label('Contact Person')
                                        ->placeholder('Select a contact')
                                        ->options(Contacts::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->live() // This makes the field reactive
                                        ->afterStateUpdated(function ($state, $set) {
                                            if ($state) {
                                                $contact = Contacts::find($state);
                                                if ($contact && $contact->email) {
                                                    // Set the to_recipients field with the contact's email
                                                    $set('to_recipients', [$contact->email]);
                                                }
                                            }
                                        }),

                                            
                                        // Select::make('requested_email')
                                        // ->label('From Email')
                                        // ->options(
                                        //         Tickets::whereNotNull('requested_email')
                                        //             ->orderBy('requested_email')
                                        //             ->pluck('requested_email', 'id')
                                        //     )
                                        // ->default(auth()->user()?->email)
                                        // ->searchable()
                                        // ->preload()
                                        // ->required(),

                                        Select::make('requested_email')
                                            ->label('From Email')
                                            ->options(function () {
                                                $userEmail = auth()->user()?->email;
                                                $query = Tickets::whereNotNull('requested_email');
                                                
                                                if ($userEmail) {
                                                    $query->where('requested_email', '!=', $userEmail);
                                                }
                                                
                                                $emails = $query->orderBy('requested_email')
                                                    ->pluck('requested_email', 'requested_email')
                                                    ->toArray();
                                                    
                                                return $userEmail 
                                                    ? [$userEmail => $userEmail] + $emails 
                                                    : $emails;
                                            })
                                            ->default(auth()->user()?->email)
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        

                                        // In your CreateTicket form class, replace the current TagsInput fields with:

                    

                                                Select::make('to_recipients')
                                                    ->label('To Recipients')
                                                    ->placeholder('Select contacts')
                                                    ->multiple()
                                                    ->searchable()
                                                    ->preload()
                                                    ->options(function () {
                                                        return Contacts::query()
                                                            ->whereNotNull('email')
                                                            ->orderBy('name')
                                                            ->limit(10)
                                                            ->get()
                                                            ->mapWithKeys(function ($contact) {
                                                                return [
                                                                    $contact->email => "{$contact->name} <{$contact->email}>"
                                                                ];
                                                            });
                                                    })
                                                    ->getSearchResultsUsing(function (string $search) {
                                                        return Contacts::query()
                                                            ->where('email', 'like', "%{$search}%")
                                                            ->orWhere('name', 'like', "%{$search}%")
                                                            ->orderBy('name')
                                                            ->limit(50)
                                                            ->get()
                                                            ->mapWithKeys(function ($contact) {
                                                                return [
                                                                    $contact->email => "{$contact->name} <{$contact->email}>"
                                                                ];
                                                            });
                                                    })
                                                    ->rules(['array'])
                                                    ->afterStateHydrated(function ($component, $state) {
                                                        if (is_string($state)) {
                                                            $component->state(json_decode($state, true));
                                                        }
                                                    })
                                                    ->dehydrateStateUsing(fn ($state) => json_encode($state)),

                                               

                                                TagsInput::make('cc_recipients'),

                                                TextInput::make('contact_ref_no'),
                                           
                                    ])->compact(),
                                    
                                Hidden::make('company_id'),
                                                                
                                Section::make('Settings & Attachments')
                                    ->schema([
                                        Select::make('SLA')
                                            ->label('SLA Type')
                                            ->placeholder('Select SLA')
                                            ->options(SlaConfiguration::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function ($set, $state) {
                                                $sla = SlaConfiguration::find($state);
                                                if ($sla) {
                                                    $set('response_time_id', $sla->id);
                                                    $set('response_time', $sla->response_time);
                                                    $set('resolution_time_id', $sla->id);
                                                    $set('resolution_time', $sla->resolution_time);
                                                }
                                            }),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('response_time')->required(),
                                                TextInput::make('resolution_time')->required(),
                                            ]),
                                            
                                        FileUpload::make('attachments')
                                            ->directory('ticket-attachments')
                                            ->multiple()
                                            ->preserveFilenames(),
                                    ])->compact(),
                                                        
                                Section::make()
                                    ->schema([
                                        DateTimePicker::make('reminder_datetime'),
                                    ])
                            ])->columnSpan(['lg' => 1]),
                    ])
                    ->columns(['lg' => 2]),
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}