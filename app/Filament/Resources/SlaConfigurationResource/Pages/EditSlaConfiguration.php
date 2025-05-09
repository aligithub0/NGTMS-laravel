<?php

namespace App\Filament\Resources\SlaConfigurationResource\Pages;

use App\Filament\Resources\SlaConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlaConfiguration extends EditRecord
{
    protected static string $resource = SlaConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit SLA Configuration';
    }
}
