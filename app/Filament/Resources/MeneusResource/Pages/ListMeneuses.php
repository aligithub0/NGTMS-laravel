<?php

namespace App\Filament\Resources\MeneusResource\Pages;

use App\Filament\Resources\MeneusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListMeneuses extends ListRecords

{
    protected static string $resource = MeneusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Menus'),
        ];
    }

    public function getTitle(): string
    {
        return 'Menus';
    }
    
}
