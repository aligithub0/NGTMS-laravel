<?php

namespace App\Filament\Resources\TicketRepliesResource\Pages;

use App\Filament\Resources\TicketRepliesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketReplies extends CreateRecord
{
    protected static string $resource = TicketRepliesResource::class;

    public function getTitle(): string
    {
        return 'Create Ticket Reply';
    }
}
