<?php

namespace App\Filament\Resources\SlaConfigurationResource\Pages;

use App\Filament\Resources\SlaConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlaConfigurations extends ListRecords
{
    protected static string $resource = SlaConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
