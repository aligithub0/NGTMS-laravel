<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimesheetResource\Pages;
use App\Filament\Resources\TimesheetResource\RelationManagers;
use App\Models\Timesheet;
use App\Models\TimesheetActivities;
use App\Models\User;
use App\Models\Project;
use App\Models\ShiftTypes;
use App\Models\TimesheetStatus;
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


class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

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

    protected static ?string $navigationIcon = 'heroicon-s-clock';
   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('ts_activity_id')
                ->label('Activity')
                ->options(TimesheetActivities::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Textarea::make('activity_description')->maxLength(1000),
                
                Select::make('user_id')
                ->label('User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload() 
                ->nullable()
                ->required(),

                Select::make('project_id')
                ->label('Project')
                ->options(Project::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('shift_type_id')
                ->label('Shift Type')
                ->options(ShiftTypes::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('ts_status_id')
                ->label('Timesheet Status')
                ->options(TimesheetStatus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                TimePicker::make('from_time')
                ->required(),

                TimePicker::make('to_time')
                ->required(),
                
                Select::make('approved_by_id')
                ->label('Approved By')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),
            

                DatePicker::make('approved_date'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('users.name')->searchable()->label('User'),
                TextColumn::make('TimesheetActivity.name')->searchable()->label('Activity'),
                TextColumn::make('activity_description')->searchable()->label('Description'),
                TextColumn::make('project.name')->searchable()->label('Project'),
                TextColumn::make('shift_type.name')->searchable()->label('Shift Type'),
                TextColumn::make('ts_status.name')->searchable()->label('Status'),
                TextColumn::make('from_time')->label('From Time'),
                TextColumn::make('to_time')->label('To Time'),
                TextColumn::make('total_time_consumed')->label('Time Consumed'),
                TextColumn::make('approved_by.name')->searchable()->label('Approved By'),
                TextColumn::make('approved_date')->searchable()->label('Approved Date'),

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
            'index' => Pages\ListTimesheets::route('/'),
            'create' => Pages\CreateTimesheet::route('/create'),
            'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
}
