<?php

namespace App\Filament\Resources\ShiftTypesResource\Pages;

use App\Filament\Resources\ShiftTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShiftTypes extends EditRecord
{
    protected static string $resource = ShiftTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
