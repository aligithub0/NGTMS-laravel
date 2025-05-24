<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketRepliesResource\Pages;
use App\Filament\Resources\TicketRepliesResource\RelationManagers;
use App\Models\TicketReplies;
use App\Models\Tickets;
use App\Models\User;
use App\Models\Priority;
use App\Models\TicketStatus;
use App\Models\TicketSource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;




class TicketRepliesResource extends Resource
{
    protected static ?string $model = TicketReplies::class;

    protected static ?string $navigationIcon = 'heroicon-s-ticket';

    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
    }

    public static function getNavigationGroup(): ?string
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getNavigationGroupByFilename($currentFile);
    }

            public static function canViewAny(): bool
        {
            return auth()->user()?->role?->name === 'Admin';
        }

        public static function canCreate(): bool
        {
            return auth()->user()?->role?->name === 'Admin';
        }

        public static function canEdit($record): bool
        {
            return auth()->user()?->role?->name === 'Admin';
        }

        public static function canDelete($record): bool
        {
            return auth()->user()?->role?->name === 'Admin';
        }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ticket_id')
                ->label('Ticket')
                ->options(Tickets::all()->pluck('title', 'id'))
                ->searchable()
                ->preload() 
                ->nullable()
                ->required(),

                Select::make('replied_by_user_id')
                ->label('Reply By User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                TextInput::make('subject')
                    ->required()
                    ->maxLength(255),

                    Toggle::make('is_desc_send_to_contact')
                    ->label('Is Desc Send to Contact')
                    ->default(false)
                    ->inline(false),    

                    Toggle::make('is_reply_from_contact')
                    ->label('Is Reply From Contact')
                    ->default(false)
                    ->inline(false), 

                    Toggle::make('is_contact_notify')
                    ->label('Is Contact Notify')
                    ->default(true)
                    ->inline(false), 

                    RichEditor::make('message')
                    ->required()
                    ->columnSpanFull(),

                    Select::make('priority_type_id')
                    ->label('Priority Type')
                    ->options(Priority::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->required(),

                    Select::make('reply_type')
                    ->label('Reply Type')
                    ->options(TicketSource::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->required(),

                        FileUpload::make('attachment_path')
                        ->label('Attachments')
                        ->directory('ticket-replies/attachments')
                        ->multiple()
                        ->downloadable()
                        ->image()
                        ->acceptedFileTypes(['image/png', 'image/jpeg'])
                        ->enableOpen() 
                        ->enableDownload() 
                        ->enableReordering(), 
                
                


                    Select::make('status_after_reply')
                    ->label('Status After Reply')
                    ->options(TicketStatus::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->required(),

                    TextInput::make('contact_ref_no')->label('Contact Ref No'),
                    TagsInput::make('cc_recipients')->label('CC Recipents')
                    ->required(),

                    TextInput::make('contact_email')
                    ->required()
                    ->email()
                    ->rules(['email', 'required', 'max:255'])->label('Contact Email'),    

                    TagsInput::make('to_recipients')->label('To Recipents')
                    ->required(),
                    
                    Toggle::make('is_read')
                    ->label('Is Read?')
                    ->default(false)
                    ->inline(false),
                    
                    Textarea::make('internal_notes'),
                    Textarea::make('external_notes'),
                 

                 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket.title')->searchable()->label('Ticket'),
                TextColumn::make('users.name')->searchable()->label('Reply By User'),
                TextColumn::make('subject')->searchable()->label('Subject'),
                TextColumn::make('priority.name')->searchable()->label('Priority Type'),
                TextColumn::make('replyType.name')->searchable()->label('Reply Type'),
                IconColumn::make('is_desc_send_to_contact')->boolean(),
                TextColumn::make('ticketStatus.name')->searchable()->label('Status After Reply'),
                TextColumn::make('contact_ref_no')->searchable()->label('Contact Ref No'),
                TextColumn::make('contact_email')->searchable()->label('Contact Email'),
                TextColumn::make('to_recipients')->searchable()->label('To Recipents'),
                TextColumn::make('cc_recipients')->searchable()->label('CC Recipents'),
                IconColumn::make('is_reply_from_contact')->boolean(),
                IconColumn::make('is_contact_notify')->boolean(),

                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicketReplies::route('/'),
            'create' => Pages\CreateTicketReplies::route('/create'),
            'edit' => Pages\EditTicketReplies::route('/{record}/edit'),
        ];
    }
}
