<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsSocialLinksResource\Pages;
use App\Filament\Resources\ContactsSocialLinksResource\RelationManagers;
use App\Models\ContactsSocialLinks;
use App\Models\Contacts;
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
use Filament\Forms\Components\RichEditor;

class ContactsSocialLinksResource extends Resource
{
    protected static ?string $model = ContactsSocialLinks::class;

    protected static ?string $navigationIcon = 'heroicon-s-phone';


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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('contact_id')
                ->label('Contact')
                ->options(Contacts::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

                Select::make('platform')
                ->label('Platform')
                ->options([
                    'Facebook' => 'Facebook',
                    'LinkedIn' => 'LinkedIn',
                    'Instant Messenger' => 'Instant Messenger',
                ])
                ->required(),

            TextInput::make('handle')
                ->label('Handle / Link')
                ->maxLength(255)
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contact.name')->searchable()->label('Contact'),
                TextColumn::make('platform')->searchable()->label('Platform'),
                TextColumn::make('handle')->searchable()->label('Handle / Link'),
            
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
            'index' => Pages\ListContactsSocialLinks::route('/'),
            'create' => Pages\CreateContactsSocialLinks::route('/create'),
            'edit' => Pages\EditContactsSocialLinks::route('/{record}/edit'),
        ];
    }
}
