<?php

namespace App\Filament\Resources\RolesMenuResource\Pages;

use App\Filament\Resources\RolesMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRolesMenu extends EditRecord
{
    protected static string $resource = RolesMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
