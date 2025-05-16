<?php

namespace App\Filament\Resources\ContactsPreferencesResource\Pages;

use App\Filament\Resources\ContactsPreferencesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactsPreferences extends ListRecords
{
    protected static string $resource = ContactsPreferencesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
