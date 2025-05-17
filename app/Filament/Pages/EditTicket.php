<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
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
use App\Models\TicketJourney;
use App\Models\TicketSource;
use App\Models\Purpose;
use App\Models\SlaConfiguration;
use App\Models\NotificationType;
use App\Models\Priority;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class EditTicket extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-pencil';
    protected static ?string $navigationLabel = 'Edit Ticket';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $title = 'Edit Ticket';
    
    protected static string $view = 'filament.pages.edit-ticket';

    public ?array $data = [];
    public Tickets $ticket;

    public function mount(Tickets $ticket): void
    {
        $this->ticket = $ticket;
        $this->form->fill([
            'title' => $this->ticket->title,
            'message' => $this->ticket->message,
            'ticket_status_id' => $this->ticket->ticket_status_id,
            'ticket_source_id' => $this->ticket->ticket_source_id,
            'priority_id' => $this->ticket->priority_id,
            'assigned_to_id' => $this->ticket->assigned_to_id,
            'notification_type_id' => json_decode($this->ticket->notification_type_id, true),
            'purpose_type_id' => json_decode($this->ticket->purpose_type_id, true),
            'contact_id' => $this->ticket->contact_id,
            'contact_ref_no' => $this->ticket->contact_ref_no,
            'requested_email' => $this->ticket->requested_email,
            'to_recipients' => json_decode($this->ticket->to_recipients, true),
            'cc_recipients' => json_decode($this->ticket->cc_recipients, true),
            'SLA' => $this->ticket->SLA,
            'response_time_id' => $this->ticket->response_time_id,
            'response_time' => $this->ticket->response_time,
            'resolution_time_id' => $this->ticket->resolution_time_id,
            'resolution_time' => $this->ticket->resolution_time,
            'reminder_datetime' => $this->ticket->reminder_datetime,
            'company_id' => $this->ticket->company_id,
            'created_by_id' => $this->ticket->created_by_id,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
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
                                            ->options(fn() => User::getAssignableUsers())
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
                                            ->dehydrateStateUsing(fn ($state) => json_encode($state)),
                                    ])
                                    ->compact(),
                            ])
                            ->columnSpan(['lg' => 1]),
                            
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
                                            ->label('Additional Attachments')
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
                                            ->nullable()
                                            ->extraAttributes(['style' => 'padding: 19px;'])
                                            ->required(),
                                    ])
                            ])
                            ->columnSpan(['lg' => 1]),
                    ])
                    ->columns(['lg' => 2]),
                
                Hidden::make('created_by_id')
                    ->default(auth()->id()),
            ])
            ->model($this->ticket)
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        try {
            $this->ticket->update($data);
            
            // Log status/assignee changes in TicketJourney
            if ($this->ticket->wasChanged('ticket_status_id') || $this->ticket->wasChanged('assigned_to_id')) {
                TicketJourney::create([
                    'ticket_id' => $this->ticket->id,
                    'from_agent' => $this->ticket->getOriginal('assigned_to_id'),
                    'to_agent' => $data['assigned_to_id'],
                    'from_status' => $this->ticket->getOriginal('ticket_status_id'),
                    'to_status' => $data['ticket_status_id'],
                    'actioned_by' => auth()->id(),
                    'logged_time' => now(),
                ]);
            }
            
            // Handle new attachments
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    TicketAttachment::create([
                        'ticket_id' => $this->ticket->id,
                        'file_url' => $attachment,
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }
            
            Notification::make()
                ->title('Ticket updated successfully')
                ->success()
                ->send();
                
        } catch (\Exception $e) {
            // Clean up any uploaded files if there was an error
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    Storage::delete($attachment);
                }
            }
            
            Notification::make()
                ->title('Error updating ticket')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}