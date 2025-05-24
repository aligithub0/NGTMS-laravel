<?php

namespace App\Filament\Resources\FieldVariablesResource\Pages;

use App\Filament\Resources\FieldVariablesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFieldVariables extends EditRecord
{
    protected static string $resource = FieldVariablesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
