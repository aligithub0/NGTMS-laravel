<?php

namespace App\Filament\Resources\ContactSegmentationResource\Pages;

use App\Filament\Resources\ContactSegmentationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactSegmentation extends EditRecord
{
    protected static string $resource = ContactSegmentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
