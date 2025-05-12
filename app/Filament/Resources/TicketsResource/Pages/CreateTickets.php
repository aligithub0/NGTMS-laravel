<?php

namespace App\Filament\Resources\TicketsResource\Pages;

use App\Filament\Resources\TicketsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTickets extends CreateRecord
{
    protected static string $resource = TicketsResource::class;
    
    public $isWidget = false;

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
