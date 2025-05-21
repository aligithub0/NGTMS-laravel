<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketAttachmentResource\Pages;
use App\Filament\Resources\TicketAttachmentResource\RelationManagers;
use App\Models\TicketAttachment;
use App\Models\User;
use App\Models\Tickets;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Validation\Rule;


class TicketAttachmentResource extends Resource
{
    protected static ?string $model = TicketAttachment::class;

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


    protected static ?string $navigationIcon = 'heroicon-s-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ticket_id')
                ->label('Ticket')
                ->options(Tickets::all()->pluck('title', 'id'))
                ->searchable()
                ->preload()
                ->required(),
                
            TextInput::make('file_url')
            ->label('File URL')
            ->required(),

              Select::make('uploaded_by')
                ->label('Uploaded By')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tickets.title')->searchable()->label('Tickets'),
                TextColumn::make('uploadedBy.name')->searchable()->label('Uploaded By'),
                TextColumn::make('created_at')->searchable()->label('Uploaded at'),
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
            'index' => Pages\ListTicketAttachments::route('/'),
            'create' => Pages\CreateTicketAttachment::route('/create'),
            'edit' => Pages\EditTicketAttachment::route('/{record}/edit'),
        ];
    }
}
