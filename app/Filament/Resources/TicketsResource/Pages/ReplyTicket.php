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
    protected static ?string $title = 'Reply to Ticket';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public $record; // Make this public for Livewire
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
        'to_recipients' => $this->record->createdBy->email ?? null,
        'message' => '',
        'internal_notes' => '',
        'notify_customer' => true,
        'attachment_path' => null,
        'cc_recipients' => null,
        'bcc' => null,
    ]);

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
                        ->downloadable()
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

        $reply = TicketReplies::create([
            'ticket_id' => $this->record->id,
            'replied_by_user_id' => auth()->id(),
            'subject' => $data['subject'],
            'message' => $data['message'],
            'internal_notes' => $data['internal_notes'] ?? null, // Save the notes
            'is_contact_notify' => $data['notify_customer'] ?? false,
            'attachment_path' => $data['attachment_path'] ?? null,
            'to_recipients' => $data['to_recipients'] ?? null,
            'cc_recipients' => $data['cc_recipients'] ?? null,
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
            'subject' => "Re: {$this->record->subject}",
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