<?php

namespace App\Filament\Resources\AgentPurposesResource\Pages;

use App\Filament\Resources\AgentPurposesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgentPurposes extends ListRecords
{
    protected static string $resource = AgentPurposesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
