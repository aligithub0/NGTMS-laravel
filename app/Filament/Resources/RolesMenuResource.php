<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Actions\Action;
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

    public static function getNavigationGroup(): ?string
    {
        $currentFile = basename((new \ReflectionClass(static::class))->getFileName());
        return NavigationOrder::getNavigationGroupByFilename($currentFile);
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
                ->multiple()
                ->searchable()
                ->preload()
                ->required()
                ->afterStateHydrated(function ($component, $state) {
                    if (is_string($state)) {
                        $component->state(json_decode($state, true));
                    }
                })
                ->dehydrateStateUsing(fn ($state) => json_encode($state))
                ->suffixAction(
                    Action::make('selectAllMenus')
                        ->label('Select All')
                        ->icon('heroicon-m-check')
                        ->action(function ($component) {
                            $component->state(
                                Meneus::all()->pluck('id')->toArray()
                            );
                        })
                ),

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
                TextColumn::make('menu_id')
                ->label('Menus')
                ->formatStateUsing(function ($state) {
                    if (empty($state)) return '-';
                    $menuIds = json_decode($state, true) ?? [];
                    return \App\Models\Meneus::whereIn('id', $menuIds)->pluck('name')->join(', ');
                }),
            
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
