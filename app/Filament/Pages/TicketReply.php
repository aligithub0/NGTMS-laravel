<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Grid;
use App\Models\Tickets;
use App\Models\TicketReplies;
use App\Models\User;
use App\Models\TicketStatus;
use App\Models\Priority;
use App\Models\TicketSource;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class TicketReply extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Ticket Replies';
    protected static ?string $title = 'Ticket Conversation';
     protected static ?string $navigationGroup = 'Reports';
    protected static string $view = 'filament.pages.ticket-reply';

    public ?array $data = [];
    public Tickets $ticket;

    public function mount(Tickets $ticket): void
    {
        $this->ticket = $ticket;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Reply Information')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255)
                            ->default($this->ticket->title),
                            
                        RichEditor::make('message')
                            ->label('Message')
                            ->required()
                            ->columnSpanFull(),
                            
                        Grid::make(3)
                            ->schema([
                                Select::make('priority_type_id')
                                    ->label('Priority')
                                    ->options(Priority::all()->pluck('name', 'id'))
                                    ->required(),
                                    
                                Select::make('reply_type')
                                    ->label('Reply Type')
                                    ->options(TicketSource::all()->pluck('name', 'id'))
                                    ->required(),
                                    
                                Select::make('status_after_reply')
                                    ->label('Status After Reply')
                                    ->options(TicketStatus::all()->pluck('name', 'id'))
                                    ->required(),
                            ]),
                    ])
                    ->compact(),
                    
                Section::make('Contact Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('contact_id')
                                    ->label('Contact Person')
                                    ->options(User::where('is_client', true)->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload(),
                                    
                                TextInput::make('contact_ref_no')
                                    ->label('Reference No'),
                                    
                                TextInput::make('contact_email')
                                    ->label('Email')
                                    ->email(),
                            ]),
                            
                        Grid::make(2)
                            ->schema([
                                TagsInput::make('to_recipients')
                                    ->label('To Recipients')
                                    ->placeholder('Add email')
                                    ->nestedRecursiveRules(['email']),
                                    
                                TagsInput::make('cc_recipients')
                                    ->label('CC Recipients')
                                    ->placeholder('Add email')
                                    ->nestedRecursiveRules(['email']),
                            ]),
                    ])
                    ->compact(),
                    
                Section::make('Notes & Attachments')
                    ->schema([
                        RichEditor::make('internal_notes')
                            ->label('Internal Notes')
                            ->disableToolbarButtons(['attachFiles', 'codeBlock'])
                            ->columnSpanFull(),
                            
                        RichEditor::make('external_notes')
                            ->label('External Notes')
                            ->disableToolbarButtons(['attachFiles', 'codeBlock'])
                            ->columnSpanFull(),
                            
                        FileUpload::make('attachment_path')
                            ->label('Attachments')
                            ->directory('ticket-replies')
                            ->multiple()
                            ->downloadable()
                            ->preserveFilenames()
                            ->columnSpanFull(),
                    ])
                    ->compact(),
                    
                Section::make('Settings')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_desc_send_to_contact')
                                    ->label('Send Description to Contact')
                                    ->default(true),
                                    
                                Toggle::make('is_reply_from_contact')
                                    ->label('Reply From Contact')
                                    ->default(false),
                                    
                                Toggle::make('is_contact_notify')
                                    ->label('Notify Contact')
                                    ->default(true),
                            ]),
                    ])
                    ->compact(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        try {
            $reply = new TicketReplies();
            $reply->ticket_id = $this->ticket->id;
            $reply->replied_by_user_id = auth()->id();
            $reply->fill($data);
            
            // Handle attachments
            if (isset($data['attachment_path'])) {
                $reply->attachment_path = json_encode($data['attachment_path']);
            }
            
            $reply->save();
            
            // Update ticket status and priority
            $this->ticket->update([
                'ticket_status_id' => $data['status_after_reply'],
                'priority_id' => $data['priority_type_id'],
            ]);
            
            Notification::make()
                ->title('Reply added successfully')
                ->success()
                ->send();
                
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error saving reply')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}