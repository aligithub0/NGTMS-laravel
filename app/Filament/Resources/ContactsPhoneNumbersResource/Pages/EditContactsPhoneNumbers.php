<?php

namespace App\Filament\Resources\ContactsPhoneNumbersResource\Pages;

use App\Filament\Resources\ContactsPhoneNumbersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactsPhoneNumbers extends EditRecord
{
    protected static string $resource = ContactsPhoneNumbersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
