<?php

namespace App\Filament\Resources\RolesMeneusResource\Pages;

use App\Filament\Resources\RolesMeneusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRolesMeneuses extends ListRecords
{
    protected static string $resource = RolesMeneusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
