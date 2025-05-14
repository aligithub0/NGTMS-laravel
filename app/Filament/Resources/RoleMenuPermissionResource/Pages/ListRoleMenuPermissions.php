<?php

namespace App\Filament\Resources\RoleMenuPermissionResource\Pages;

use App\Filament\Resources\RoleMenuPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoleMenuPermissions extends ListRecords
{
    protected static string $resource = RoleMenuPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Role Menu Permission'),
        ];
    }
}
