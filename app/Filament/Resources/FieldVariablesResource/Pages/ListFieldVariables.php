<?php

namespace App\Filament\Resources\FieldVariablesResource\Pages;

use App\Filament\Resources\FieldVariablesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFieldVariables extends ListRecords
{
    protected static string $resource = FieldVariablesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Field Variable'),
        ];
    }
}
