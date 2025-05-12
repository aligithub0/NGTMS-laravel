<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlaConfigurationResource\Pages;
use App\Filament\Resources\SlaConfigurationResource\RelationManagers;
use App\Models\SlaConfiguration;
use App\Models\Department;
use App\Models\Purpose;
use App\Models\User;
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

class SlaConfigurationResource extends Resource
{
    protected static ?string $model = SlaConfiguration::class;


    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

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

    public static function getNavigationLabel(): string
    {
        return 'SLA Configurations'; 
    
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
                
                Select::make('department_id')
                ->label('Department')
                ->options(Department::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),


                Select::make('purpose_id')
                ->label('Purpose')
                ->options(Purpose::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),


                Select::make('response_time')
                ->label('Response Time')
                ->options([
                    '5' => '5 minutes',
                    '10' => '10 minutes',
                    '15' => '15 minutes',
                    '20' => '20 minutes',
                    '25' => '25 minutes',
                    '30' => '30 minutes',
                ])
                ->required()
                ->searchable(),

                Select::make('resolution_time')
                ->label('Resolution Time')
                ->options([
                    '5' => '5 minutes',
                    '10' => '10 minutes',
                    '15' => '15 minutes',
                    '20' => '20 minutes',
                    '25' => '25 minutes',
                    '30' => '30 minutes',
                ])
                ->required()
                ->searchable(),

                Select::make('escalated_to_user_id')
                ->label('Escalated to')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('department.name')->label('Department'),
                TextColumn::make('purpose.name')->label('Purpose'),
                TextColumn::make('response_time')->label('Response Time'),
                TextColumn::make('resolution_time')->label('Resolution Time'),
                TextColumn::make('escalated.name')->label('Escalated To'),

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
            'index' => Pages\ListSlaConfigurations::route('/'),
            'create' => Pages\CreateSlaConfiguration::route('/create'),
            'edit' => Pages\EditSlaConfiguration::route('/{record}/edit'),
        ];
    }
}
