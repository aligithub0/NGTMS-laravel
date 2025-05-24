<?php

namespace App\Filament\Resources\ContactsSocialLinksResource\Pages;

use App\Filament\Resources\ContactsSocialLinksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactsSocialLinks extends EditRecord
{
    protected static string $resource = ContactsSocialLinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
