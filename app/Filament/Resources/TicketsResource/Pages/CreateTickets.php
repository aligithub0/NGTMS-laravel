<?php

namespace App\Filament\Resources\TicketsResource\Pages;

use App\Filament\Resources\TicketsResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTickets extends CreateRecord
{
    protected static string $resource = TicketsResource::class;
    
    public $isWidget = false;

    protected function afterCreate(): void
{
    $Ticket = $this->record;

    Notification::make()
        ->title('New Ticket Created')
        ->body("**New Brand {$Ticket->name} created!**");
        // ->actions([
        //     Action::make('View')
        //         ->url(
        //             TicketsResource::getUrl('edit', ['record' => $Ticket])
        //         ),
        // ])
        // ->sendToDatabase(auth()->user());
}


    protected function getHeaderActions(): array
    {
        return $this->isWidget ? [] : parent::getHeaderActions();
    }
    
    protected function getFormActions(): array
    {
        return $this->isWidget ? [] : parent::getFormActions();
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->isWidget ? TicketsResource::getUrl('dashboard') : TicketsResource::getUrl('index');
    }
}
