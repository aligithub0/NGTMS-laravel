<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TagsInput;
use App\Models\User;
use App\Models\Contacts;
use App\Models\Tickets;
use App\Models\TicketAttachment;
use App\Models\TicketStatus;
use App\Models\TicketJourney;
use App\Models\TicketSource;
use App\Models\Purpose;
use App\Models\SlaConfiguration;
use App\Models\NotificationType;
use App\Models\Company;
use App\Models\Priority;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Storage;

class CreateTicket extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-ticket';
    protected static ?string $navigationLabel = 'New Ticket';
    protected static ?string $title = 'New Ticket';
    protected static ?string $navigationGroup = 'Ticket Management';
    protected static string $view = 'filament.pages.create-ticket';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->name === 'Admin';
    }


    public ?array $data = [];

    public function mount(): void
{
    $authUser = auth()->user();
    $defaultStatus = TicketStatus::where('is_default', true)->first();
    $defaultPriority = Priority::where('is_default', true)->first();
    $defaultSource = TicketSource::where('is_default', true)->first();
    $defaultSla = SlaConfiguration::where('is_default', true)->first();
    $defaultNotificationTypes = NotificationType::where('is_default', true)->pluck('id')->toArray();
    $defaultPurposes = Purpose::where('is_default', true)->pluck('id')->toArray();

    $this->form->fill([
        'created_by_id' => auth()->id(),
        'assigned_to_id' => $authUser->id, // Always default to current user
        'ticket_status_id' => $defaultStatus?->id,
        'priority_id' => $defaultPriority?->id,
        'ticket_source_id' => $defaultSource?->id,
        'reminder_flag' => false,
        'SLA' => $defaultSla?->id,
        'response_time_id' => $defaultSla?->id,
        'response_time' => $defaultSla?->response_time,
        'resolution_time_id' => $defaultSla?->id,
        'resolution_time' => $defaultSla?->resolution_time,
        'notification_type_id' => $defaultNotificationTypes,
        'purpose_type_id' => $defaultPurposes,
        'requested_email' => auth()->user()?->email,
    ]);
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        // Left Column
                        Grid::make(1)
                            ->schema([
                                Section::make('Ticket Details')
                                    ->schema([
                                        Select::make('purpose_type_id')
                                        ->label('Purpose')
                                        ->placeholder('Select purpose')
                                        ->options(Purpose::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                            
                                        TextInput::make('title')
                                            ->label('Title')
                                            ->placeholder('Enter ticket Title')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        RichEditor::make('message')
                                            ->required()
                                            ->extraAttributes(['class' => 'max-h-[100px]'])
                                            ->extraAttributes(['class' => 'max-h-[100px]'])
                                            ->columnSpanFull(),
                                            
        
                                        Select::make('ticket_status_id')
                                            ->label('Status')
                                            ->placeholder('Select status')
                                            ->options(TicketStatus::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                                    
                                        Select::make('ticket_source_id')
                                            ->label('Source')
                                            ->placeholder('Select source')
                                            ->options(TicketSource::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),



                                        Select::make('priority_id')
                                            ->label('Priority')
                                            ->placeholder('Select priority')
                                            ->options(Priority::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
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
                                            ->rules(['required', 'integer', 'exists:users,id'])

                                            ->default(auth()->id()) // Default to current user
                                            ->required()
                                            ->rules(['required', 'integer', 'exists:users,id']),

                                        Select::make('notification_type_id')
                                            ->label('Notification Types')
                                            ->placeholder('Select notification types')
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
                                            ->dehydrateStateUsing(fn ($state) => json_encode($state)),
                                    ])
                                    ->compact(),
                            ])
                            ->columnSpan(['lg' => 1]),
                            
                        // Right Column
                        Grid::make(1)
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
                                            ->disabled()
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

                            TagsInput::make('cc_recipients')
                                ->placeholder('Add email and press enter')
                                ->label('CC Recipients')
                                // ->required()
                                ->suggestions(
                                    Tickets::query()
                                        ->whereNotNull('cc_recipients')
                                        ->pluck('cc_recipients')
                                        ->flatten()
                                        ->unique()
                                        ->values()
                                        ->toArray()
                                )
                                ->rules(['array'])
                                ->afterStateHydrated(function ($component, $state) {
                                    if (is_string($state)) {
                                        $component->state(json_decode($state, true));
                                    }
                                })
                                ->dehydrateStateUsing(fn ($state) => json_encode($state)),
                                        TextInput::make('contact_ref_no')
                                            ->label('Contact Reference No')
                                            ->placeholder('Enter contact reference number')
                                            ->nullable(),
                                    ])
                                    ->compact(),
                                    
                                Hidden::make('company_id')
                                    ->default(auth()->user()->company_id)
                                    ->dehydrated(),
                                                                    
                                
                                Hidden::make('company_id')
                                    ->default(auth()->user()->company_id)
                                    ->dehydrated(),
                                                                    
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
                                                Select::make('response_time_id')
                                                    ->label('Response Time')
                                                    ->options(SlaConfiguration::all()->pluck('response_time', 'id'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($set, $state) {
                                                        $sla = SlaConfiguration::find($state);
                                                        if ($sla) $set('response_time', $sla->response_time);
                                                    }),
                                                Hidden::make('response_time'),
                                                
                                                Select::make('resolution_time_id')
                                                    ->label('Resolution Time')
                                                    ->options(SlaConfiguration::all()->pluck('resolution_time', 'id'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($set, $state) {
                                                        $sla = SlaConfiguration::find($state);
                                                        if ($sla) $set('resolution_time', $sla->resolution_time);
                                                    }),
                                                Hidden::make('resolution_time'),
                                            ]),
                                            
                                            
                                        FileUpload::make('attachments')
                                            ->label('Attachments')
                                            ->placeholder('Drag & drop files here or click to upload')
                                            ->directory('ticket-attachments')
                                            ->multiple()
                                            ->downloadable()
                                            ->extraAttributes(['class' => 'max-h-[100px]'])
                                            ->preserveFilenames()
                                            ->openable()
                                            ->acceptedFileTypes(['image/*'])
                                            ->maxSize(10240)
                                            ->columnSpanFull(),
                                    ])
                                    ->compact(),  
                                    
                                Section::make()
                                    ->schema([
                                        
                                        DateTimePicker::make('reminder_datetime')
                                            ->nullable(),
                                            
                                    ])
                            ])
                            ->columnSpan(['lg' => 1]),
                    ])
                    ->columns(['lg' => 2]),
                    
                // Hidden field
                Hidden::make('created_by_id')
                    ->default(auth()->id()),
                    
                // Submit Button
                Actions::make([
                    Action::make('create')
                        ->label('Create Ticket')
                        ->submit('create')
                        ->size('lg')
                ])->alignEnd()
                
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        
        // Ensure created_by_id is set
        if (!isset($data['created_by_id'])) {
            $data['created_by_id'] = auth()->id();
        }

        // Force company_id if not set
        $data['company_id'] = $data['company_id'] ?? auth()->user()->company_id;

        // Force company_id if not set
        $data['company_id'] = $data['company_id'] ?? auth()->user()->company_id;
        
        // Ensure arrays are properly encoded
        if (isset($data['purpose_type_id']) && is_array($data['purpose_type_id'])) {
            $data['purpose_type_id'] = (int) $data['purpose_type_id'];
        }
        
        if (isset($data['notification_type_id']) && is_array($data['notification_type_id'])) {
            $data['notification_type_id'] = json_encode($data['notification_type_id']);
        }
        
        try {
            // Create the ticket
            $ticket = Tickets::create($data);
            
            // Create the initial TicketJourney record
            TicketJourney::create([
                'ticket_id' => $ticket->id,
                'from_agent' => auth()->id(),
                'to_agent' => $data['assigned_to_id'],
                'from_status' => $data['ticket_status_id'],
                'to_status' => $data['ticket_status_id'],
                'actioned_by' => auth()->id(),
                'logged_time' => now(),
            ]);
            
            // Create the initial TicketJourney record
            TicketJourney::create([
                'ticket_id' => $ticket->id,
                'from_agent' => auth()->id(),
                'to_agent' => $data['assigned_to_id'],
                'from_status' => $data['ticket_status_id'],
                'to_status' => $data['ticket_status_id'],
                'actioned_by' => auth()->id(),
                'logged_time' => now(),
            ]);
            
            // Handle attachments
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    TicketAttachment::create([
                        'ticket_id' => $ticket->id,
                        'file_url' => $attachment,
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }
            
            // Show success notification
            Notification::make()
                ->title('Ticket created successfully')
                ->success()
                ->send();
                
            // Redirect to tickets dashboard
            $this->redirect(TicketsManager::getUrl());
            $this->redirect(TicketsManager::getUrl());
        } catch (\Exception $e) {
            // Clean up any uploaded files if there was an error
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    Storage::delete($attachment);
                }
            }
    
    
            // Show error notification
            Notification::make()
                ->title('Error creating ticket')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}