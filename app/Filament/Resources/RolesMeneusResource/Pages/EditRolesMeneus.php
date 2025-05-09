<?php

namespace App\Filament\Resources\RolesMeneusResource\Pages;

use App\Filament\Resources\RolesMeneusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRolesMeneus extends EditRecord
{
    protected static string $resource = RolesMeneusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
