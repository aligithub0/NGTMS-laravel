<?php

namespace App\Filament\Resources\ContactsSocialLinksResource\Pages;

use App\Filament\Resources\ContactsSocialLinksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactsSocialLinks extends ListRecords
{
    protected static string $resource = ContactsSocialLinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
