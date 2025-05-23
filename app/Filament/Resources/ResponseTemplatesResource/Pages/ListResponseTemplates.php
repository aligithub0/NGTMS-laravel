<?php

namespace App\Filament\Resources\ResponseTemplatesResource\Pages;

use App\Filament\Resources\ResponseTemplatesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponseTemplates extends ListRecords
{
    protected static string $resource = ResponseTemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Response Templates'),
        ];
    }
}
