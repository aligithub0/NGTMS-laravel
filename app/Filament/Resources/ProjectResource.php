<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectTypes;
use App\Models\Company;
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
use Filament\Forms\Components\DatePicker;


class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
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
                ->default(true),
                
                Select::make('project_type_id')
                ->label('Project Type')
                ->options(ProjectTypes::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('company_id')
                ->label('Company')
                ->options(Company::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


                DatePicker::make('start_date')->required(),
                DatePicker::make('end_date')->required(),

                 Select::make('project_owner_id')
                ->label('Project Owner')
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
                TextColumn::make('name')->sortable()->searchable(),
                IconColumn::make('status')->boolean(),
                TextColumn::make('project_type.name')->sortable()->searchable(),
                TextColumn::make('company.name')->sortable()->searchable(),
                TextColumn::make('start_date')->sortable()->searchable(),
                TextColumn::make('end_date')->sortable()->searchable(),
                TextColumn::make('end_date')->sortable()->searchable(),
                TextColumn::make('project_owner.name')->sortable()->searchable(),

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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
