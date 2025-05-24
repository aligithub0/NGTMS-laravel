<?php

namespace App\Filament\Resources\StatusWorkflowResource\Pages;

use App\Filament\Resources\StatusWorkflowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusWorkflow extends EditRecord
{
    protected static string $resource = StatusWorkflowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
