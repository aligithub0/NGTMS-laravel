<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketStatusResource\Pages;
use App\Filament\Resources\TicketStatusResource\RelationManagers;
use App\Models\TicketStatus;
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
use Filament\Forms\Components\Textarea;


class TicketStatusResource extends Resource
{
    protected static ?string $model = TicketStatus::class;

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

    public static function getNavigationLabel(): string
    {
        return 'Ticket Status'; 
    
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->rules([
                    'required',
                    'regex:/^[A-Za-z\s]+$/',
                    'max:255',
                ])
                ->helperText('Only letters and spaces are allowed.'),



                Toggle::make('status')
                ->label('Active')
                ->default(true)
                ->inline(false),    

                Textarea::make('description')->required()->rows(2),

            
                Toggle::make('is_default')
                ->label('Is Default ?')
                ->default(false)
                ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('description')->searchable(),
                IconColumn::make('status')->boolean(),
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
            'index' => Pages\ListTicketStatuses::route('/'),
            'create' => Pages\CreateTicketStatus::route('/create'),
            'edit' => Pages\EditTicketStatus::route('/{record}/edit'),
        ];
    }
}
