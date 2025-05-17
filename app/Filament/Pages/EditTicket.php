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
use App\Models\TicketJourney;
use App\Models\TicketSource;
use App\Models\Purpose;
use App\Models\SlaConfiguration;
use App\Models\NotificationType;
use App\Models\Company;
use App\Models\Priority;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class EditTicket extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-ticket';
    protected static ?string $navigationLabel = 'Edit Ticket';
    protected static ?string $title = 'Edit Ticket';
    protected static ?string $navigationGroup = 'Reports';
    protected static string $view = 'filament.pages.edit-ticket';

    public Tickets $ticket;
    public ?array $data = [];

    public function mount(Tickets $ticket): void
    {
        $this->ticket = $ticket;
        
        // Decode JSON fields to arrays
        $purposeTypeId = json_decode($ticket->purpose_type_id, true) ?? [];
        $notificationTypeId = json_decode($ticket->notification_type_id, true) ?? [];
        
        // Get existing attachments
        // $attachments = $ticket->attachments->pluck('file_url')->toArray();
        
        $this->form->fill([
            'purpose_type_id' => $purposeTypeId,
            'title' => $ticket->title,
            'message' => $ticket->message,
            'ticket_status_id' => $ticket->ticket_status_id,
            'ticket_source_id' => $ticket->ticket_source_id,
            'priority_id' => $ticket->priority_id,
            'assigned_to_id' => $ticket->assigned_to_id,
            'notification_type_id' => $notificationTypeId,
            'contact_id' => $ticket->contact_id,
            'contact_ref_no' => $ticket->contact_ref_no,
            'requested_email' => $ticket->requested_email,
            'to_recipients' => $ticket->to_recipients,
            'cc_recipients' => $ticket->cc_recipients,
            'company_id' => $ticket->company_id,
            'SLA' => $ticket->sla_configuration_id,
            'response_time_id' => $ticket->sla_configuration_id,
            'response_time' => $ticket->response_time,
            'resolution_time_id' => $ticket->sla_configuration_id,
            'resolution_time' => $ticket->resolution_time,
            // 'attachments' => $attachments,
            'reminder_datetime' => $ticket->reminder_datetime,
            'created_by_id' => $ticket->created_by_id,
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
                                            ->nullable()
                                            ->extraAttributes(['style' => 'padding: 19px;'])
                                            ->required(),
                                    ])
                                ])
                                ->columnSpan(['lg' => 1]),
                            ])
                            ->columns(['lg' => 2]),
                            
                        // Hidden field
                        Hidden::make('created_by_id'),
                        
                        // Submit Button
                        Actions::make([
                            Action::make('update')
                                ->label('Update Ticket')
                                ->submit('update')
                                ->size('lg')
                        ])->alignEnd()
                    ])
                    ->statePath('data');
    }

    public function update(): void
    {
        $data = $this->form->getState();
        
        // Ensure arrays are properly encoded
        if (isset($data['purpose_type_id']) && is_array($data['purpose_type_id'])) {
            $data['purpose_type_id'] = json_encode($data['purpose_type_id']);
        }
        
        if (isset($data['notification_type_id']) && is_array($data['notification_type_id'])) {
            $data['notification_type_id'] = json_encode($data['notification_type_id']);
        }
        
        try {
            // Update the ticket
            $this->ticket->update($data);
            
            // Handle attachments
            if (isset($data['attachments'])) {
                // First, delete any attachments that were removed
                $currentAttachments = $this->ticket->attachments->pluck('file_url')->toArray();
                $newAttachments = $data['attachments'];
                
                $attachmentsToDelete = array_diff($currentAttachments, $newAttachments);
                foreach ($attachmentsToDelete as $attachment) {
                    Storage::delete($attachment);
                    TicketAttachment::where('file_url', $attachment)->delete();
                }
                
                // Then add new attachments
                $attachmentsToAdd = array_diff($newAttachments, $currentAttachments);
                foreach ($attachmentsToAdd as $attachment) {
                    TicketAttachment::create([
                        'ticket_id' => $this->ticket->id,
                        'file_url' => $attachment,
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }
            
            // Show success notification
            Notification::make()
                ->title('Ticket updated successfully')
                ->success()
                ->send();
                
            // Redirect to tickets dashboard
            $this->redirect(TicketsResource::getUrl());
        } catch (\Exception $e) {
            // Show error notification
            Notification::make()
                ->title('Error updating ticket')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}