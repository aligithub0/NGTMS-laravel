<?php

namespace App\Filament\Resources\MeneusResource\Pages;

use App\Filament\Resources\MeneusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMeneus extends CreateRecord
{
    protected static string $resource = MeneusResource::class;

    public function getTitle(): string
    {
        return 'Create Menus';
    }
}
