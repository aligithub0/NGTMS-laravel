<?php

namespace App\Filament\Resources\ShiftTypesResource\Pages;

use App\Filament\Resources\ShiftTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShiftTypes extends ListRecords
{
    protected static string $resource = ShiftTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Shift Type'),
        ];
    }
}
