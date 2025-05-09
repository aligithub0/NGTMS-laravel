<?php

namespace App\Filament\Resources\AgentPurposesResource\Pages;

use App\Filament\Resources\AgentPurposesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgentPurposes extends EditRecord
{
    protected static string $resource = AgentPurposesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
