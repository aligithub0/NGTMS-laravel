<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserStatusResource\Pages;
use App\Filament\Resources\UserStatusResource\RelationManagers;
use App\Models\UserStatus;
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

class UserStatusResource extends Resource
{
    protected static ?string $model = UserStatus::class;

    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'User Status'; 
    
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
            ->default(true),                    ]);
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
            'index' => Pages\ListUserStatuses::route('/'),
            'create' => Pages\CreateUserStatus::route('/create'),
            'edit' => Pages\EditUserStatus::route('/{record}/edit'),
        ];
    }
}
