<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusWorkflowResource\Pages;
use App\Filament\Resources\StatusWorkflowResource\RelationManagers;
use App\Models\StatusWorkflow;
use App\Models\TicketStatus;
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

class StatusWorkflowResource extends Resource
{
    protected static ?string $model = StatusWorkflow::class;

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
                Select::make('from_status_id')
                ->label('From Status')
                ->options(TicketStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('to_status_id')
                ->label('To Status')
                ->options(TicketStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Toggle::make('is_default')
                ->label('Is Default?')
                ->default(false)
                ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fromStatus.name')->searchable()->label('From Status'),
                TextColumn::make('toStatus.name')->searchable()->label('To Status'),
                IconColumn::make('is_default')->boolean()->label('Is Default?'),
                
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
            'index' => Pages\ListStatusWorkflows::route('/'),
            'create' => Pages\CreateStatusWorkflow::route('/create'),
            'edit' => Pages\EditStatusWorkflow::route('/{record}/edit'),
        ];
    }
}
