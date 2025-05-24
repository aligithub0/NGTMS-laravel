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
    
    // Then load the relationships
    $this->record->load([
        'replies.user',
        'ticketStatus',
        'priority',
        'createdBy',
        'assignedTo',
        'slaConfiguration'
    ]);

    // Pre-fill form with default values
    $this->form->fill([
        'subject' => "Re: {$this->record->title}", // Changed from subject to title if that's your field
        'to_recipients' => $this->record->createdBy->email ?? null,
        'message' => '',
        'notify_customer' => true,
        'attachment_path' => null,
    ]);
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Reply Details')
                    ->schema([
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Subject')
                            ->columnSpanFull(),

                        TextInput::make('to_recipients')
                            ->label('To')
                            ->email()
                            ->required()
                            ->columnSpanFull(),
                    
                        TextInput::make('cc_recipients')
                            ->label('CC')
                            ->email()
                            ->columnSpanFull(),
                        
                        RichEditor::make('message')
                            ->required()
                            ->maxLength(5000)
                            ->placeholder('Type your reply here...')
                            ->columnSpanFull()
                            ->extraInputAttributes(['style' => 'min-height: 150px'])
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),

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
                    $this->record->update(['ticket_status_id' => 'closed']);
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