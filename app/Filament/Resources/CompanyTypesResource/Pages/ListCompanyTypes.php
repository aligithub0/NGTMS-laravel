<?php

namespace App\Filament\Resources\CompanyTypesResource\Pages;

use App\Filament\Resources\CompanyTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyTypes extends ListRecords
{
    protected static string $resource = CompanyTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
