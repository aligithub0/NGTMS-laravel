<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftTypesResource\Pages;
use App\Filament\Resources\ShiftTypesResource\RelationManagers;
use App\Models\ShiftTypes;
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
use Filament\Forms\Components\TimePicker;


class ShiftTypesResource extends Resource
{
    protected static ?string $model = ShiftTypes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextInput::make('name')
                ->required()
                ->unique(ignoreRecord: true) 
                ->rules([
                    'required',
                    'regex:/^[A-Za-z\s]+$/',
                    'max:255'
                ,
                ])
                ->helperText('Only letters and spaces are allowed.'),


                TimePicker::make('from_time')
                ->required(),

                TimePicker::make('to_time')
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
                TextColumn::make('name')->searchable(),
                TextColumn::make('from_time')->label('From Time'),
                TextColumn::make('to_time')->label('To Time'),
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
            'index' => Pages\ListShiftTypes::route('/'),
            'create' => Pages\CreateShiftTypes::route('/create'),
            'edit' => Pages\EditShiftTypes::route('/{record}/edit'),
        ];
    }
}
