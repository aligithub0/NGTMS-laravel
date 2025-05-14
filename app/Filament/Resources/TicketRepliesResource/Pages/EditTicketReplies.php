<?php

namespace App\Filament\Resources\TicketRepliesResource\Pages;

use App\Filament\Resources\TicketRepliesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketReplies extends EditRecord
{
    protected static string $resource = TicketRepliesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
