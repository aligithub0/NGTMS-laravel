<?php

namespace App\Filament\Resources\TicketsResource\Pages;

use App\Filament\Resources\TicketsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use App\Models\Purpose;
use App\Models\TicketStatus;
use App\Models\TicketSource;
use App\Models\Priority;
use App\Models\User;
use App\Models\NotificationType;
use App\Models\SlaConfiguration;

class EditTickets extends EditRecord
{
    protected static string $resource = TicketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        //     Actions\Action::make('save')
        //         ->label('Update Ticket')
        //         ->submit('save')
        //         ->color('primary'),
        ];
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        // Left Column
                        Grid::make()
                            ->schema([
                                Section::make('Ticket Details')
                                    ->schema([
                                        Select::make('purpose_type_id')
                                            ->label('Purpose')
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
                                            ->required()
                                            ->maxLength(255),
                                            
                                        RichEditor::make('message')
                                            ->required()
                                            ->columnSpanFull(),
                                            
                                        Select::make('ticket_status_id')
                                            ->options(TicketStatus::all()->pluck('name', 'id'))
                                            ->required(),
                                            
                                        Select::make('ticket_source_id')
                                            ->options(TicketSource::all()->pluck('name', 'id'))
                                            ->required(),

                                        Select::make('priority_id')
                                            ->options(Priority::all()->pluck('name', 'id'))
                                            ->required(),
                                            
                                        Select::make('assigned_to_id')
                                            ->options(User::getAssignableUsers())
                                            ->required(),

                                        Select::make('notification_type_id')
                                            ->options(NotificationType::all()->pluck('name', 'id'))
                                            ->multiple()
                                            ->required()
                                            ->afterStateHydrated(function ($component, $state) {
                                                if (is_string($state)) {
                                                    $component->state(json_decode($state, true));
                                                }
                                            })
                                            ->dehydrateStateUsing(fn ($state) => json_encode($state)),
                                    ])->compact(),
                            ])->columnSpan(['lg' => 1]),
                            
                        // Right Column
                        Grid::make()
                            ->schema([
                                Section::make('Contact Information')
                                    ->schema([
                                        Select::make('contact_id')
                                            ->options(User::all()->pluck('name', 'id'))
                                            ->required(),
                                            
                                        TextInput::make('contact_ref_no'),
                                            
                                        TextInput::make('requested_email')
                                            ->email()
                                            ->required(),

                                        Grid::make(2)
                                           ->schema([
                                                TagsInput::make('to_recipients')->required(),
                                                TagsInput::make('cc_recipients')->required(),
                                           ])
                                    ])->compact(),
                                    
                                Hidden::make('company_id'),
                                                                
                                Section::make('Settings & Attachments')
                                    ->schema([
                                        Select::make('sla_configuration_id')
                                            ->options(SlaConfiguration::all()->pluck('name', 'id'))
                                            ->reactive()
                                            ->afterStateUpdated(function ($set, $state) {
                                                $sla = SlaConfiguration::find($state);
                                                if ($sla) {
                                                    $set('response_time', $sla->response_time);
                                                    $set('resolution_time', $sla->resolution_time);
                                                }
                                            }),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('response_time')->required(),
                                                TextInput::make('resolution_time')->required(),
                                            ]),
                                            
                                        FileUpload::make('attachments')
                                            ->directory('ticket-attachments')
                                            ->multiple()
                                            ->preserveFilenames(),
                                    ])->compact(),
                                                        
                                Section::make()
                                    ->schema([
                                        DateTimePicker::make('reminder_datetime'),
                                    ])
                            ])->columnSpan(['lg' => 1]),
                    ])
                    ->columns(['lg' => 2]),
            ]);
    }

    

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}