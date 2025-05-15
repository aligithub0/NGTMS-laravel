<?php

namespace App\Filament\Resources\TicketJourneyResource\Pages;

use App\Filament\Resources\TicketJourneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketJourneys extends ListRecords
{
    protected static string $resource = TicketJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Ticket Journey'),
        ];
    }
}
