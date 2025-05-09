<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeneusResource\Pages;
use App\Filament\Resources\MeneusResource\RelationManagers;
use App\Models\Meneus;
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

class MeneusResource extends Resource
{

    public static function getNavigationLabel(): string
    {
        return 'Menus'; 
    
    }

    public static function getNavigationSort(): int
{
    $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
    return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
}
    
    protected static ?string $model = Meneus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    
            Select::make('parent_id')
                ->label('Menu')
                ->options(Meneus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


            Toggle::make('status')
                ->label('Active')
                ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),

                TextColumn::make('parent.name')
                    ->label('Menu')
                    ->sortable(),
    
                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
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
            'index' => Pages\ListMeneuses::route('/'),
            'create' => Pages\CreateMeneus::route('/create'),
            'edit' => Pages\EditMeneus::route('/{record}/edit'),
        ];
    }
}
