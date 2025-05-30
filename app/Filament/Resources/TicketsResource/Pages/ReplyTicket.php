<?php

namespace App\Filament\Resources\TicketsResource\Pages;

use App\Models\TicketReplies;
use App\Models\StatusWorkflow;
use App\Filament\Resources\TicketsResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\Storage;
use App\Models\Tickets;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Filament\Forms\Components\DateTimePicker;
use Carbon\Carbon;
use App\Models\Notification as NotificationModel;


class ReplyTicket extends Page
{
    use WithPagination;
    
    protected static string $resource = TicketsResource::class;
    protected static string $view = 'filament.pages.reply-ticket';
    protected static ?string $title = 'Ticket Details';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public $record;
    public $showBcc = false;
    public ?array $replyData = [];
    
    #[Url]
    public $search = '';
    
    #[Url]
    public $statusFilter = null;
    
    public $selectedTicketId = null;

    public $totalTicketsCount = 0;

    protected $queryString = ['search'];

    public $unreadCount = 0;

    public $readFilter = null;

    public bool $showStatusEdit = false;

    public bool $showAssigneeEdit = false;

    public $newStatusId;

    public $newAssigneeId;

    public $relatedTickets;

    public $ticketJourney;

    public $activityLogs;

    public $showDatePicker = false;

    public $scheduledDate;

    public function updatedSearch($value)
    {
        $this->resetPage();
    }

    
    public function mount($record): void
    {

        if (!$record || $record === 'new') {
        $this->redirect(TicketsResource::getUrl('reply'));
        return;
    }

        $this->record = Tickets::findOrFail($record);
        // dd($this->record);
        $this->selectedTicketId = $record;
        $baseQuery = $this->applyVisibilityFilters(Tickets::query());
    
        $this->totalTicketsCount = $baseQuery->count();
        $this->unreadCount = $baseQuery->clone()->where('is_read', false)->count();

        $this->newStatusId = $this->record->ticket_status_id;
        $this->newAssigneeId = $this->record->assigned_to;
    
        // Mark as read when opening
        if (!$this->record->is_read) {
            $this->record->update(['is_read' => true]);
            $this->unreadCount--;
        }

         $this->loadRelatedData();
        // $this->record->load([
        //     'replies.user',
        //     'ticketStatus',
        //     'priority',
        //     'createdBy',
        //     'assignedTo',
        //     'slaConfiguration'
        // ]);

        $this->form->fill([
            'subject' => "Re: {$this->record->title}",
            'to_recipients' => $this->record->requested_email ?? null,
            'message' => '',
            'internal_notes' => '',
            'notify_customer' => true,
            'attachment_path' => null,
            'cc_recipients' => null,
            'bcc' => null,
        ]);
    }



    protected function loadRelatedData(): void
{
    $this->record->load([
        'replies.user',
        'ticketStatus',
        'priority',
        'createdBy',
        'assignedTo',
        'slaConfiguration',
        'relatedTickets',
        'journeyEvents' => function($query) {
            $query->orderBy('created_at', 'desc');
        },
        'activityLogs'
    ]);

    // Get related tickets
    $this->relatedTickets = $this->record->relatedTickets;
        
    // Get ticket journey (already loaded via eager loading)
    $this->ticketJourney = $this->record->journeyEvents;

    // Get activity logs (already loaded via eager loading)
    $this->activityLogs = $this->record->activityLogs;
    
}


protected function getAllowedStatuses()
{
    // Get all possible transitions from current status
    $allowedTransitions = StatusWorkflow::where('from_status_id', $this->record->ticket_status_id)
        ->with('toStatus')
        ->get()
        ->pluck('toStatus')
        ->unique()
        ->filter(); // remove null values

    // If no specific transitions are defined, return all statuses (fallback)
    if ($allowedTransitions->isEmpty()) {
        return \App\Models\TicketStatus::all();
    }

    return $allowedTransitions;
}




    protected function applyVisibilityFilters($query)
{
    $user = auth()->user();
    
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

   public function toggleStatusEdit(): void
{
    $this->showStatusEdit = !$this->showStatusEdit;
}

public function toggleAssigneeEdit(): void
{
    $this->showAssigneeEdit = !$this->showAssigneeEdit;
}


public function closeScheduleModal()
{
    $this->showScheduleModal = false;
}


public function updateStatus(): void
{
    $this->validate([
        'newStatusId' => [
            'required',
            'exists:ticket_statuses,id',
            function ($attribute, $value, $fail) {
                $allowedStatuses = $this->getAllowedStatuses()->pluck('id')->toArray();
                
                if (!in_array($value, $allowedStatuses)) {
                    $fail('This status transition is not allowed.');
                }
            },
        ]
    ]);
    
    $this->record->update(['ticket_status_id' => $this->newStatusId]);
    $this->showStatusEdit = false;
    $this->dispatch('notify', type: 'success', message: 'Status updated successfully');
    
    // Refresh the allowed statuses after update
    $this->getViewData();
}

public function updateAssignee(): void
{
    $this->validate(['newAssigneeId' => 'nullable|exists:users,id']);
    $this->record->update(['assigned_to_id' => $this->newAssigneeId]);
    $this->showAssigneeEdit = false;
    $this->dispatch('notify', type: 'success', message: 'Assignee updated successfully');
}
  
protected function getViewData(): array
{
    return [
        'statuses' => $this->getAllowedStatuses(),
        'assignableUsers' => \App\Models\User::get(),
        'canAssignToOthers' => auth()->user()->where('assigned_to_others'),
    ];
}

    public function selectTicket($ticketId)
    {
        $ticket = Tickets::findOrFail($ticketId);
        
        // Mark as read if unread
        if (!$ticket->is_read) {
            $ticket->update(['is_read' => true]);
            $this->unreadCount--;
        }
        
        $this->selectedTicketId = $ticketId;
        $this->record = $ticket;
        
         $this->loadRelatedData();
        
        $this->form->fill([
            'subject' => "Re: {$this->record->title}",
            'to_recipients' => $this->record->requested_email ?? null,
            'message' => '',
            'internal_notes' => '',
            'notify_customer' => true,
            'attachment_path' => null,
            'cc_recipients' => null,
            'bcc' => null,
        ]);
    }

    
    public function setFilter($type, $value)
    {
        if ($type === 'status') {
            $this->statusFilter = $value;
        }
    }

   public function getStatusesProperty()
{
    return \App\Models\TicketStatus::withCount(['tickets' => function($query) {
        $this->applyVisibilityFilters($query)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('ticket_id', 'like', '%' . $this->search . '%');
                });
            });
    }])->get();
}
    
  public function getTicketsProperty()
{
    $query = $this->applyVisibilityFilters(
        Tickets::query()->with(['priority', 'ticketStatus', 'assignedTo', 'createdBy'])
    );

    // Apply filters
    $query->when($this->statusFilter, function ($query) {
            $query->where('ticket_status_id', $this->statusFilter);
        })
        ->when($this->readFilter !== null, function ($query) {
            $query->where('is_read', $this->readFilter);
        })
        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('ticket_id', 'like', '%'.$this->search.'%')
                  ->orWhere('requested_email', 'like', '%'.$this->search.'%')
                  ->orWhereHas('createdBy', function ($q) {
                      $q->where('name', 'like', '%'.$this->search.'%');
                  });
            });
        })
        ->orderBy('created_at', 'desc');

    return $query->paginate(10);
}

public function setReadFilter($value)
{
    $this->readFilter = $value;
    $this->resetPage();
}

    
    
    public function createNewTicket()
    {
        return redirect()->to(TicketsResource::getUrl('create'));
    }

    public function downloadAttachment($filename)
    {
        $path = 'ticket-attachments/' . $filename;
        
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path);
        }
        
        $this->dispatch('notify', type: 'error', message: 'File not found');
    }

    public function removeAttachment($filename)
    {
        $path = 'ticket-attachments/' . $filename;
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        
        $this->replyData['attachment_path'] = null;
    }


    protected function processAttachments()
{
    if (!isset($this->replyData['attachment_path']) || empty($this->replyData['attachment_path'])) {
        return null;
    }

    $attachments = [];
    $storagePath = 'ticket-attachments/' . now()->format('Y/m');

    // If it's a single file (not array)
    if (!is_array($this->replyData['attachment_path'])) {
        $file = $this->replyData['attachment_path'];
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $path = $file->store($storagePath);
            $attachments[] = $path;
        } elseif (is_string($file)) {
            // If it's already a stored path (from edit, etc.)
            $attachments[] = $file;
        }
        return json_encode($attachments);
    }

    // Process multiple files
    foreach ($this->replyData['attachment_path'] as $file) {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            try {
                $path = $file->store($storagePath);
                $attachments[] = $path;
            } catch (\Exception $e) {
                // Log error but continue with other files
                \Log::error("Failed to store attachment: " . $e->getMessage());
                continue;
            }
        } elseif (is_string($file)) {
            // If it's already a stored path
            $attachments[] = $file;
        }
    }

    return !empty($attachments) ? json_encode($attachments) : null;
}
    

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('to_recipients')
                                    ->label('To')
                                    ->inlineLabel()
                                    ->email()
                                    ->required()
                                    ->extraAttributes(['class' => 'flex'])
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->extraAttributes(['class' => 'flex w-full']),

                        Grid::make()
                            ->schema([
                                TextInput::make('cc_recipients')
                                    ->label('CC')
                                    ->inlineLabel()
                                    ->email()
                                    ->extraAttributes(['class' => 'ml-1'])
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->extraAttributes(['class' => 'ml-1 flex']),

                        Grid::make()
                            ->schema([
                                TextInput::make('bcc')
                                    ->label('BCC')
                                    ->inlineLabel()
                                    ->email()
                                    ->extraAttributes(['class' => 'ml-1'])
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->extraAttributes(['class' => 'ml-1 flex']),
                                
                        Grid::make()
                            ->schema([
                                TextInput::make('subject')
                                    ->label('Subject')
                                    ->inlineLabel()
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Subject')
                                    ->columnSpanFull()
                                    ->extraAttributes(['class' => 'gap-1']),
                            ])
                            ->columns(1)
                            ->extraAttributes(['class' => 'ml-1 flex']),

                        RichEditor::make('message')
                            ->required()
                            ->maxLength(5000)
                            ->placeholder('Type your reply here...')
                            ->columnSpanFull()
                            ->extraInputAttributes(['style' => 'min-height: 150px']),
                        
                        Textarea::make('internal_notes')
                            ->label('Internal Notes')
                            ->placeholder('Add any internal notes here (not visible to customer)')
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->rows(3),

                        Checkbox::make('notify_customer')
                            ->label('Notify customer')
                            ->default(true),
                            
                        FileUpload::make('attachment_path')
                            ->label('Attachment')
                            ->directory('ticket-attachments')
                            ->multiple()
                            ->maxFiles(5)
                            ->downloadable()
                            ->disk('public')
                            ->openable()
                            ->preserveFilenames()
                            ->acceptedFileTypes([
                                'image/*', 
                                'application/pdf', 
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            ])
                            ->maxSize(10240)
                            ->columnSpanFull()
                            ->helperText('Uploaded files will be renamed to ensure uniqueness'),

                             DateTimePicker::make('scheduledDate')
                                ->label('Schedule Reply For')
                                ->hidden(!$this->showDatePicker)
                                ->minDate(now())
                                ->required()
                                ->columnSpanFull(),
                                
                    ])
            ])
            ->statePath('replyData');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Ticket')
                ->url(fn () => TicketsResource::getUrl('view', ['record' => $this->record]))
                ->color('gray'),
                
            Action::make('close')
                ->label('Close Ticket')
                ->color('danger')
                ->icon('heroicon-o-lock-closed')
                ->requiresConfirmation()
                ->modalHeading('Close Ticket')
                ->modalDescription('Are you sure you want to close this ticket? The customer will be notified.')
                ->action(function () {
                    $this->record->update(['ticket_status_id' => 8]);
                    Notification::make()
                        ->title('Ticket closed successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

   public function submitReply(): void
{
    try {

        
        $data = $this->form->getState();
        $tempAttachmentPaths = [];

        $isScheduled = isset($data['scheduledDate']) && 
               !empty($data['scheduledDate']) && 
               Carbon::parse($data['scheduledDate'])->isFuture();

        // First store files with temporary names
        if (isset($data['attachment_path'])) {
            $attachments = $data['attachment_path'];
            
            if (is_array($attachments)) {
                foreach ($attachments as $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $originalName = $file->getClientOriginalName(); // Original file name
                    $path = $file->storeAs('ticket-attachments', $originalName, 'public');
                    $tempAttachmentPaths[] = 'ticket-attachments/' . $originalName;
                } elseif (is_string($file)) {
                                $tempAttachmentPaths[] = $file; // Keep existing files
                    }
                }
            } elseif($attachments instanceof \Illuminate\Http\UploadedFile) {
    $originalName = $attachments->getClientOriginalName();
    $path = $attachments->storeAs('ticket-attachments', $originalName, 'public');
    $tempAttachmentPaths[] = 'ticket-attachments/' . $originalName;
} elseif (is_string($attachments)) {
                $tempAttachmentPaths[] = $attachments; // Keep existing file
            }
        }

        // Create the reply to get the ID
        $reply = TicketReplies::create([
            'ticket_id' => $this->record->id,
            'replied_by_user_id' => auth()->id(),
            'subject' => $this->record->ticket_id . ' - ' . $data['subject'],
            'message' => $data['message'],
            'internal_notes' => $data['internal_notes'] ?? null,
            'is_contact_notify' => $data['notify_customer'] ?? false,
            'attachment_path' => null, // Will update after renaming
            'to_recipients' => $data['requested_email'] ?? null,
            'cc_recipients' => $data['cc_recipients'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'is_scheduled' => $isScheduled, // This was missing
            'scheduled_at' => $isScheduled ? $data['scheduledDate'] : null,
        ]);

        // Now rename files to include ticket_id, reply ID and datetime
        $finalAttachmentPaths = [];
        foreach ($tempAttachmentPaths as $tempPath) {
            $originalName = pathinfo($tempPath, PATHINFO_FILENAME);
            $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
            $cleanTicketId = str_replace([' ', '-'], '_', $this->record->ticket_id);
            $cleanOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '', $originalName);
            
            $newName = sprintf(
                '%s_%d_%s_%s.%s',
                $cleanTicketId,
                $reply->id,
                now()->format('Ymd_His'),
                $cleanOriginalName,
                $extension
            );
            
            Storage::disk('public')->move($tempPath, 'ticket-attachments/' . $newName);
            $finalAttachmentPaths[] = 'ticket-attachments/' . $newName;
        }

        // Update the reply with final paths
        if (!empty($finalAttachmentPaths)) {
            $reply->update(['attachment_path' => json_encode($finalAttachmentPaths)]);
        }

        $this->createNotificationForReply($reply, $data);

        // Update ticket's updated_at timestamp
        $this->record->touch();

        Notification::make()
            ->title('Reply sent successfully')
            ->body('Your reply has been added to the ticket.')
            ->success()
            ->send();

        // Reset form
        $this->form->fill([
            'subject' => "Re: {$this->record->title}",
            // 'message' => '',
            'internal_notes' => '',
            'notify_customer' => true,
            'attachment_path' => null,
            'cc_recipients' => null,
            'bcc' => null,
            'scheduledDate' => null,
        ]);
         $this->showDatePicker = false;

          $this->dispatch('replyData.message');

    } catch (\Exception $e) {
        // Clean up any uploaded files if error occurs
        if (isset($tempAttachmentPaths)) {
            foreach ($tempAttachmentPaths as $tempPath) {
                if (Str::startsWith($tempPath, 'ticket-attachments/temp_')) {
                    Storage::disk('public')->delete($tempPath);
                }
            }
        }

        Notification::make()
            ->title('Error sending reply')
            ->body($e->getMessage())
            ->danger()
            ->send();
    }
}


protected function createNotificationForReply(TicketReplies $reply, array $data): void
{
    // Only create notification if customer should be notified
    if (!$reply->is_contact_notify) {
        return;
    }

    $notificationData = [
        'type' => 'ticket_reply',
        'ticket_id' => $reply->ticket_id,
        'reply_id' => $reply->id,
        'subject' => $reply->subject,
        'body_text' => strip_tags($reply->message),
        'body_html' => $reply->message,
        'delivery_channel' => 'email', // or other channels as needed
        'to_emails' => [$reply->requested_email],
        'cc_emails' => $reply->cc_recipients ? [$reply->cc_recipients] : null,
        'bcc_emails' => $reply->bcc ? [$reply->bcc] : null,
        'status' => $reply->is_scheduled ? 'pending' : 'pending',
        'scheduled_at' => $reply->scheduled_at,
        'notifiable_type' => 'App\Models\User', // or other notifiable type
        'notifiable_id' => auth()->id(), // the user who created the reply
        'data' => [
            'ticket_id' => $reply->ticket_id,
            'reply_id' => $reply->id,
            'attachments' => $reply->attachment_path ? json_decode($reply->attachment_path, true) : null,
        ]
    ];

    // Create the notification
    NotificationModel::create($notificationData);
}
   
}