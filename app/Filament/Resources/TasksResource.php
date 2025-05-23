<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TasksResource\Pages;
use App\Filament\Resources\TasksResource\RelationManagers;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Tickets;
use App\Models\Project;
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

class TasksResource extends Resource
{
    protected static ?string $model = Tasks::class;

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
                TextInput::make('title')->required()->maxLength(255),

                Textarea::make('description')->required()->rows(2),

                Select::make('project_id')
                ->label('Project')
                ->options(Project::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('ticket_id')
                ->label('Tickets')
                ->options(Tickets::all()->pluck('title', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('assigned_to')
                ->label('Assigned To')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                DatePicker::make('due_date')->nullable() 
                ->required(),
                


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
                TextColumn::make('title')->searchable()->label('Title'),
                TextColumn::make('projects.name')->searchable()->label('Projects'),
                TextColumn::make('tickets.title')->searchable()->label('Tickets'),
                TextColumn::make('AssignedTo.name')->searchable()->label('Assigned To'),
                TextColumn::make('due_date')->searchable()->label('Due Date'),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTasks::route('/create'),
            'edit' => Pages\EditTasks::route('/{record}/edit'),
        ];
    }
}
