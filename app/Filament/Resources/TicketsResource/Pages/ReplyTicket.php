<?php

namespace App\Filament\Resources\TicketsResource\Pages;

use App\Models\TicketReplies;
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



class ReplyTicket extends Page
{
    protected static string $resource = TicketsResource::class;
    protected static string $view = 'filament.pages.reply-ticket';
    protected static ?string $title = 'Reply Details';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public $record; // Make this public for Livewire
    public $showBcc = false;
    public ?array $replyData = [];

    public function mount($record): void
{
    // First resolve the record from the ID
    $this->record = Tickets::findOrFail($record);
    // dd( $this->record);
    // Then load the relationships
    $this->record->load([
        'replies.user',
        'ticketStatus',
        'priority',
        'createdBy',
        'assignedTo',
        'slaConfiguration'
    ]);

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

public $replyData_1 = [
    'message' => ''
];

public function save()
{
    // Save the HTML content safely
    $message = $this->replyData_1['message'];

    // Validation
    $this->validate([
        'replyData.message' => 'required|string',
    ]);

    // Store or process the message
}

public function renderMarkdown($content)
{
    return Str::markdown($content);
}

// public function removeAttachment(): void
// {
//     $this->form->getState()['attachment_path'] = null;
//     $this->replyData['attachment_path'] = null;
// }

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
                    ->extraAttributes(['class' => 'ml-1 flex ']),

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
                    ->extraAttributes(['class' => 'ml-1 flex ']),
                        
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
                    ->extraAttributes(['class' => 'ml-1 flex ']),// <-- controls space
                    // Reduce margin-left of input



                    
                    
                    RichEditor::make('message')
                        ->required()
                        ->maxLength(5000)
                        ->placeholder('Type your reply here...')
                        ->columnSpanFull()
                        ->extraInputAttributes(['style' => 'min-height: 150px']),
                    
                    // Add this new field for internal notes
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
                        ->disk('public') // Add this line
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

    $attachmentPaths = [];

    if (isset($data['attachment_path'])) {
        $attachments = $data['attachment_path'];

        if (is_array($attachments)) {
            foreach ($attachments as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->store('ticket-attachments', 'public');
                    $attachmentPaths[] = 'ticket-attachments/' . basename($path);
                } elseif (is_string($file)) {
                    $attachmentPaths[] = $file;
                }
            }
        } elseif ($attachments instanceof \Illuminate\Http\UploadedFile) {
            $path = $attachments->store('ticket-attachments', 'public');
            $attachmentPaths[] = 'ticket-attachments/' . basename($path);
        } elseif (is_string($attachments)) {
            $attachmentPaths[] = $attachments;
        }
    }

    $reply = TicketReplies::create([
        'ticket_id' => $this->record->id,
        'replied_by_user_id' => auth()->id(),
        'subject' => $this->record->ticket_id . ' - ' . $data['subject'],
        'message' => $data['message'],
        'internal_notes' => $data['internal_notes'] ?? null,
        'is_contact_notify' => $data['notify_customer'] ?? false,
        'attachment_path' => !empty($attachmentPaths) ? json_encode($attachmentPaths) : null, // store as JSON
        'to_recipients' => $data['requested_email'] ?? null,
        'cc_recipients' => $data['cc_recipients'] ?? null,
        'bcc' => $data['bcc'] ?? null,
    ]);

        // Update ticket's updated_at timestamp
        $this->record->touch();

        Notification::make()
            ->title('Reply sent successfully')
            ->body('Your reply has been added to the ticket.')
            ->success()
            ->send();

        // Reset form except subject
        $this->form->fill([
            'subject' => "{$this->record->subject}",
            'message' => '',
            'internal_notes' => '',
            'notify_customer' => true,
            'attachment_path' => null,
            'cc_recipients' => null,
        ]);

    } catch (\Exception $e) {
        Notification::make()
            ->title('Error sending reply')
            ->body($e->getMessage())
            ->danger()
            ->send();
    }
}

}