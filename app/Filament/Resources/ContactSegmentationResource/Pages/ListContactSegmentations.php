<?php

namespace App\Filament\Resources\ContactSegmentationResource\Pages;

use App\Filament\Resources\ContactSegmentationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactSegmentations extends ListRecords
{
    protected static string $resource = ContactSegmentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Contact Segmentation'),
        ];
    }
}
