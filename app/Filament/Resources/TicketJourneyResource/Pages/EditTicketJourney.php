<?php

namespace App\Filament\Resources\TicketJourneyResource\Pages;

use App\Filament\Resources\TicketJourneyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketJourney extends EditRecord
{
    protected static string $resource = TicketJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
