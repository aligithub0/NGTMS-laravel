<?php

namespace App\Filament\Resources\RolesMenuResource\Pages;

use App\Filament\Resources\RolesMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRolesMenus extends ListRecords
{
    protected static string $resource = RolesMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
