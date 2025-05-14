<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleMenuPermissionResource\Pages;
use App\Filament\Resources\RoleMenuPermissionResource\RelationManagers;
use App\Models\RoleMenuPermission;
use App\Models\RolesMenu;
use App\Models\Meneus;
use App\Models\Role;
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
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TagsColumn;

class RoleMenuPermissionResource extends Resource
{
    protected static ?string $model = RoleMenuPermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

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

                Select::make('role_id')
                ->label('Roles')
                ->options(Role::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),

                Select::make('role_menu_id')
                ->label('Menu')
                ->options(Meneus::all()->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->nullable()
                ->required(),
            

              

                CheckboxList::make('objects')
                ->label('Objects Permissions')
                ->options([
                    'view' => 'View',
                    'edit' => 'Edit',
                    'delete' => 'Delete', 
                    'history' => 'View History',
                    'export' => 'Export',
                ])
                ->columns(4) 
                ->required(),

                Toggle::make('status')
                ->label('Status')
                ->default(true)
                ->inline(false),   

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('roles.name')->label('Roles'),


                TextColumn::make('menus.name') 
                ->label('Menu')
                ->searchable(),
            
            
                TagsColumn::make('objects')
                ->label('Page Permissions')
                ->getStateUsing(function (RoleMenuPermission $record) {
                    $permissionLabels = [
                        'view' => 'View',
                        'edit' => 'Edit',
                        'delete' => 'Delete',
                        'history' => 'History',
                        'export' => 'Export',
                    ];
                    
                   
                    return array_map(function ($permission) use ($permissionLabels) {
                        return $permissionLabels[$permission] ?? $permission;
                    }, $record->objects ?? []);
                })
                ->separator(','),

                IconColumn::make('status')
                ->label('Status')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle'),
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
            'index' => Pages\ListRoleMenuPermissions::route('/'),
            'create' => Pages\CreateRoleMenuPermission::route('/create'),
            'edit' => Pages\EditRoleMenuPermission::route('/{record}/edit'),
        ];
    }
}
