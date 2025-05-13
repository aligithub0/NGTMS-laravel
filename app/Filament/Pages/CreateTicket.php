<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use App\Models\User;
use App\Models\Ticket;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;

class CreateTicket extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Create Ticket';
    protected static ?string $title = 'Create New Ticket';
    protected static ?string $navigationGroup = 'Reports';
    protected static string $view = 'filament.pages.create-ticket';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'requester' => 'pwlenz9@gmail.com',
            'subject' => 'Overcast shipment tracking',
            'group' => 'Columns Support',
            'assignee' => 'Support + Hash D',
            'followers' => ['Support - Vista D'],
            'priority' => 'neutral',
            'public_reply' => 'Thank you, usher for providing detailed information.',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ticket Information')
                    ->columns(2)
                    ->schema([
                        Select::make('type')
                            ->label('Type')
                            ->options([
                                'shipment_tracking' => 'Shipment Tracking',
                                'general' => 'General Inquiry',
                                'technical' => 'Technical Issue',
                            ])
                            ->default('shipment_tracking')
                            ->required()
                            ->native(false),
                            
                        TextInput::make('requester')
                            ->label('Requester')
                            ->disabled(),
                            
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->columnSpanFull(),
                            
                        Select::make('group')
                            ->label('Group')
                            ->options([
                                'columns_support' => 'Columns Support',
                                'billing' => 'Billing',
                                'technical' => 'Technical Support',
                            ])
                            ->required()
                            ->native(false),
                            
                        Select::make('assignee')
                            ->label('Assignee')
                            ->options([
                                'support_hash_d' => 'Support + Hash D',
                                'support_team_a' => 'Support Team A',
                                'support_team_b' => 'Support Team B',
                            ])
                            ->required()
                            ->native(false),
                            
                        TagsInput::make('followers')
                            ->label('Followers')
                            ->suggestions([
                                'Support - Vista D',
                                'Support - Team A',
                                'Support - Team B',
                            ])
                            ->columnSpanFull(),
                    ]),
                    
                Section::make('Priority & Notes')
                    ->schema([
                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'low' => 'Low',
                                'neutral' => 'Neutral',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->required()
                            ->native(false),
                            
                        Textarea::make('public_reply')
                            ->label('Public Reply')
                            ->placeholder('Internet note')
                            ->columnSpanFull(),
                            
                        Actions::make([
                            Action::make('create')
                                ->label('Create Ticket')
                                ->submit('create')
                                ->color(Color::Green)
                                ->icon('heroicon-o-check')
                                ->size('lg')
                        ])->alignEnd()
                    ])
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        
        Ticket::create([
            'type' => $data['type'],
            'requester' => $data['requester'],
            'subject' => $data['subject'],
            'group' => $data['group'],
            'assignee' => $data['assignee'],
            'followers' => $data['followers'],
            'priority' => $data['priority'],
            'public_reply' => $data['public_reply'],
            'created_by_id' => auth()->id(),
        ]);
        
        Notification::make()
            ->title('Ticket created successfully')
            ->success()
            ->send();
            
        $this->redirect(TicketsDashboard::getUrl());
    }
}