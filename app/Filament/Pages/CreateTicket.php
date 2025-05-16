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
use App\Models\Tickets;
use App\Models\TicketAttachment;
use App\Models\TicketStatus;
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
    protected static ?string $navigationLabel = 'Create Ticket';
    protected static ?string $title = 'Create New Ticket';
    protected static ?string $navigationGroup = 'Reports';
    protected static string $view = 'filament.pages.create-ticket';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'created_by_id' => auth()->id(),
            'ticket_status_id' => TicketStatus::where('name', 'Open')->first()?->id,
            'priority_id' => Priority::where('name', 'Medium')->first()?->id,
            'reminder_flag' => false,
        ]);
    }

    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // First Row: Ticket Details (left) and Assignment (right)
                Grid::make()
                    ->schema([
                        // Left Column
                        Grid::make(1)
                            ->schema([
                                Section::make('Ticket Details')
                                    ->schema([

                                        Select::make('purpose_type_id')
                                            ->label('Purpose')
                                            ->placeholder('Select purposes')
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
                                            ->dehydrateStateUsing(fn ($state) => json_encode($state)),
                                            // ->suffixAction(
                                            //     Action::make('selectAllPurpose')
                                            //         ->label('Select All')
                                            //         ->icon('heroicon-m-check')
                                            //         ->action(function ($component) {
                                            //             $component->state(
                                            //                 Purpose::all()->pluck('id')->toArray()
                                            //             );
                                            //         })
                                            // ),
                                            
                                        TextInput::make('title')
                                            ->label('Title')
                                            ->placeholder('Enter ticket Title')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        RichEditor::make('message')
                                            ->required()
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
                                            ->placeholder('Select assignee')
                                            ->options(User::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),

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
                                        
                                            
                                    ])
                                    ->compact(),


                                    // Section::make('Assignment & Categorization')
                                    // ->schema([
                                        
                                    // ])
                                    // ->compact(),
                                    // Section::make('Response & Resolution')
                                    // ->schema([
                                       
                                    // ])
                                    // ->compact(),
       
                         

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
                                            ->options(User::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                            
                                        TextInput::make('contact_ref_no')
                                            ->label('Contact Reference No')
                                            ->placeholder('Enter contact reference number')
                                            ->nullable(),
                                            
                                        TextInput::make('requested_email')
                                            ->label('Requested By Email')
                                            ->placeholder('Enter email address')
                                            ->required()
                                            ->email()
                                            ->rules(['email', 'required', 'max:255']),

                                    Grid::make(2)
                                       ->schema([
                                        TagsInput::make('to_recipients')
                                        ->placeholder(' ')
                                            ->label('To Recipients')
                                            ->required(),
                                            
                                        TagsInput::make('cc_recipients')
                                        ->placeholder(' ')
                                            ->label('CC Recipients')
                                            ->required(),
                                       ])
                                    ])
                                    ->compact(),
                                    
                                    Hidden::make('company_id')
                                    ->default(auth()->user()->company_id)
                                    ->dehydrated(),
                                                                    
                                    // Section::make('Notes')
                                    // ->schema([
                                    //     Textarea::make('internal_note')
                                    //         ->label('Internal Note')
                                    //         ->rows(1)
                                    //         ->required(),
                                            
                                    //     Textarea::make('external_note')
                                    //         ->label('External Note')
                                    //         ->rows(2)
                                    //         ->required(),
                                    // ])
                                    // ->compact(),

                                    

                                    Section::make('Settings & Attachments')
                                    ->schema([
                                        Select::make('SLA')
                                            ->label('SLA Type')
                                            ->placeholder('Select SLA')
                                            ->options(SlaConfiguration::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
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

                                   
                                    
                                        // Toggle::make('reminder_flag')
                                        //     ->label('Set Reminder?')
                                        //     ->default(false)
                                        //     ->inline(false)
                                        //     ->reactive(),
                                            
                                        Section::make()
                                        ->schema([
                                        DateTimePicker::make('reminder_datetime')
                                        // ->hiddenLabel()
                                            ->nullable()
                                            ->extraAttributes(['style' => 'padding: 19px;'])
                                            ->required(),
                                            // ->visible(fn ($get) => $get('reminder_flag')),
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


        $data = $this->form->getState();
    
        // Force company_id if not set
        $data['company_id'] = $data['company_id'] ?? auth()->user()->company_id;
        
        // Ensure arrays are properly encoded
        if (isset($data['purpose_type_id']) && is_array($data['purpose_type_id'])) {
            $data['purpose_type_id'] = json_encode($data['purpose_type_id']);
        }
        
        if (isset($data['notification_type_id']) && is_array($data['notification_type_id'])) {
            $data['notification_type_id'] = json_encode($data['notification_type_id']);
        }
        
        try {
            // Create the ticket
            $ticket = Tickets::create($data);
            
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