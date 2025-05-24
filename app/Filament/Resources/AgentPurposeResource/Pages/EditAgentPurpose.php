<?php

namespace App\Filament\Resources\AgentPurposeResource\Pages;

use App\Filament\Resources\AgentPurposeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgentPurpose extends EditRecord
{
    protected static string $resource = AgentPurposeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
