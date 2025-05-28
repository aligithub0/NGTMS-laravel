<?php

namespace App\Filament\Resources\ProjectTypesResource\Pages;

use App\Filament\Resources\ProjectTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectTypes extends EditRecord
{
    protected static string $resource = ProjectTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
