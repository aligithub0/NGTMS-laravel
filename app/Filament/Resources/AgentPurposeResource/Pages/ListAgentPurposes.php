<?php

namespace App\Filament\Resources\AgentPurposeResource\Pages;

use App\Filament\Resources\AgentPurposeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgentPurposes extends ListRecords
{
    protected static string $resource = AgentPurposeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
