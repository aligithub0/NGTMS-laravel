<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RolesMenuResource\Pages;
use App\Filament\Resources\RolesMenuResource\RelationManagers;
use App\Models\RolesMenu;
use App\Models\Role;
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

class RolesMenuResource extends Resource
{
    protected static ?string $model = RolesMenu::class;


    public static function getNavigationSort(): int
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getSortOrderByFilename($currentFile) ?? parent::getNavigationSort();
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('role_id')
                ->label('Roles')
                ->options(Role::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),


                Select::make('menu_id')
                ->label('Menus')
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
                TextColumn::make('menues.name')->label('Menues'),
                TextColumn::make('roles.name')->label('Roles'),
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
            'index' => Pages\ListRolesMenus::route('/'),
            'create' => Pages\CreateRolesMenu::route('/create'),
            'edit' => Pages\EditRolesMenu::route('/{record}/edit'),
        ];
    }
}
