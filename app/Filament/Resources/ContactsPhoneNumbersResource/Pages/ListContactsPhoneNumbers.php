<?php

namespace App\Filament\Resources\ContactsPhoneNumbersResource\Pages;

use App\Filament\Resources\ContactsPhoneNumbersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactsPhoneNumbers extends ListRecords
{
    protected static string $resource = ContactsPhoneNumbersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
