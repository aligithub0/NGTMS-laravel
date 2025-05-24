<?php

namespace App\Filament\Resources\StatusWorkflowResource\Pages;

use App\Filament\Resources\StatusWorkflowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusWorkflows extends ListRecords
{
    protected static string $resource = StatusWorkflowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Status Workflow'),
        ];
    }
}
