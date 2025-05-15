<?php

namespace App\Filament\Resources\TicketRepliesResource\Pages;

use App\Filament\Resources\TicketRepliesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketReplies extends ListRecords
{
    protected static string $resource = TicketRepliesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Ticket Reply'),
        ];
    }
}
