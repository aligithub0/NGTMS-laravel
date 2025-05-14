<?php

namespace App\Filament\Resources\RoleMenuPermissionResource\Pages;

use App\Filament\Resources\RoleMenuPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoleMenuPermission extends EditRecord
{
    protected static string $resource = RoleMenuPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
