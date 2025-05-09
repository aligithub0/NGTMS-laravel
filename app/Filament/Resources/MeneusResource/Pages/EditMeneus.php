<?php

namespace App\Filament\Resources\MeneusResource\Pages;

use App\Filament\Resources\MeneusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeneus extends EditRecord
{
    protected static string $resource = MeneusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }

  
}
