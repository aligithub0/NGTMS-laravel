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
use Filament\Forms\Components\Hidden;


class MeneusResource extends Resource
{

    public static function getNavigationLabel(): string
    {
        return 'Menus'; 
    
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
    
    protected static ?string $model = Meneus::class;

    protected static ?string $navigationIcon = 'heroicon-s-bars-3';

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
                ->label('Parent Menu')
                ->options(Meneus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable(),

                TextInput::make('page_path')
                ->label('Page Path')
                ->required()
                ->dehydrateStateUsing(function ($state, ?Meneus $record) {
                    // For new records or when path is changed
                    if (!$record || $state !== $record->page_path) {
                        return $state; // The mutator will handle encryption
                    }
                    
                    // For existing records when path isn't changed
                    return $record->getRawPagePath();
                })
                ->formatStateUsing(function (?Meneus $record) {
                    return $record?->page_path ?? '';
                }),


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

                TextColumn::make('parent.name')
                    ->label('Parent Menu')
             ,

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
