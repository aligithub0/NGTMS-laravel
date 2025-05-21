<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimesheetStatusResource\Pages;
use App\Filament\Resources\TimesheetStatusResource\RelationManagers;
use App\Models\TimesheetStatus;
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

class TimesheetStatusResource extends Resource

{
    protected static ?string $model = TimesheetStatus::class;

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

    protected static ?string $navigationIcon = 'heroicon-s-clock';

    public static function getNavigationLabel(): string
    {
        return 'Timesheet Status'; 
    
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
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
            'index' => Pages\ListTimesheetStatuses::route('/'),
            'create' => Pages\CreateTimesheetStatus::route('/create'),
            'edit' => Pages\EditTimesheetStatus::route('/{record}/edit'),
        ];
    }
}
