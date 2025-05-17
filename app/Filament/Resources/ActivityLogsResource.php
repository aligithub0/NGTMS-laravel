<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogsResource\Pages;
use App\Filament\Resources\ActivityLogsResource\RelationManagers;
use App\Models\ActivityLog;
use App\Models\Tickets;
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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;


class ActivityLogsResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

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

                TextInput::make('ip_address')
                ->label('IP Address')
                ->required()
                ->maxLength(45), 

                KeyValue::make('logs')
                ->label('Activity Logs')
                ->addButtonLabel('Add Log Entry')
                ->keyLabel('Field')
                ->valueLabel('Value')
                ->reorderable()
                ->columns(1)
                ->helperText('Enter key-value pairs like action, user, timestamp'),

                


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket.title')->searchable()->label('Ticket'),
                TextColumn::make('ip_address')->searchable()->label('IP Address'),
                TextColumn::make('logs')
                    ->limit(50)
                    ->wrap()
                    ->label('Logs'),
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
            'index' => Pages\ListActivityLogs::route('/'),
            'create' => Pages\CreateActivityLogs::route('/create'),
            'edit' => Pages\EditActivityLogs::route('/{record}/edit'),
        ];
    }
}
