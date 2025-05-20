<?php

namespace App\Filament\Pages;

use App\Models\TicketReplies;
use App\Models\Tickets;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;

class TicketReply extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Ticket Management';
    protected static string $view = 'filament.pages.ticket-reply';

            public static function getNavigationSort(): ?int
            {
                return 2;
            }

            public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->name === 'Admin';
    }

    public Tickets $ticket;
    public ?array $replyData = [];

    public function mount(Tickets $ticket): void
{
    $this->ticket = $ticket->load([
        'replies.user',  // This loads the user for each reply
        'ticketStatus',
        'priority',
        'createdBy',    // Changed from 'user' to 'createdBy'
        'assignedTo'    // If you need the assigned user as well
    ]);
    $this->form->fill(['subject' => "Re: {$ticket->subject}"]);
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        TextInput::make('subject')
                            ->required()
                            ->default("Re: {$this->ticket->subject}")
                            ->placeholder('Subject'),
                        
                       RichEditor::make('message')
                        ->required()
                        ->maxLength(5000)
                        ->placeholder('Type your reply here...'),

                         Textarea::make('internal_notes')
                         ->label('Internal Notes')
                        ->required()
                        ->maxLength(5000)
                        ->placeholder('notes here...'),
                            
                        FileUpload::make('attachment_path')
                            ->label('Attachment')  // Singular
                            ->directory('ticket-attachments')
                            ->downloadable()
                            ->openable()
                            ->preserveFilenames()
                            ->acceptedFileTypes(['image/*', 'application/pdf', 'application/msword'])
                            ->maxSize(5120), // 5MB
                            
                        // Grid::make()
                        // ->schema([    
                        // Toggle::make('is_desc_send_to_contact')
                        //     ->label('Show description to contact')
                        //     ->inline(false),
                            
                        // Toggle::make('is_contact_notify')
                        //     ->label('Notify contact of reply')
                        //     ->inline(false),

                        // ])
                    ])
                    ,
            ])
            ->statePath('replyData');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('close')
            ->label('Close Ticket')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function () {
                $this->ticket->update(['ticket_status_id' => 'closed']);  // Changed from status_id
                Notification::make()
                    ->title('Ticket closed successfully')
                    ->success()
                    ->send();
            }),
                
            // Action::make('assign')
            //     ->label('Assign Ticket')
            //     ->form([
            //         Select::make('assigned_to_id')
            //             ->label('Assign to')
            //             ->options(\App\Models\User::all()->pluck('name', 'id'))
            //             ->required(),
            //     ])
            //     ->action(function (array $data) {
            //         $this->ticket->update($data);
            //         Notification::make()
            //             ->title('Ticket assigned successfully')
            //             ->success()
            //             ->send();
            //     }),
        ];
    }

    public function submitReply(): void
{
    $data = $this->form->getState();

    $reply = TicketReplies::create([
        'ticket_id' => $this->ticket->id,
        'replied_by_user_id' => auth()->id(),
        'subject' => $data['subject'],
        'message' => $data['message'],
        'is_desc_send_to_contact' => $data['is_desc_send_to_contact'] ?? false,
        'is_contact_notify' => $data['is_contact_notify'] ?? false,
        'attachment_path' => $data['attachment_path'] ?? null,
        'internal_notes' => $data['internal_notes'] ?? null,
    ]);

    // Optionally update ticket status if needed
    // $this->ticket->update(['ticket_status_id' => 'replied']);

    Notification::make()
        ->title('Reply sent successfully')
        ->body('Your reply has been added to the ticket.')
        ->success()
        ->send();

    $this->form->fill(['subject' => "Re: {$this->ticket->subject}", 'message' => '']);
}

    public function getTitle(): string|Htmlable
    {
        return "Reply to Ticket #{$this->ticket->id}";
    }
}