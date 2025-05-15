<?php

namespace App\Filament\Resources\TaskAttachmentsResource\Pages;

use App\Filament\Resources\TaskAttachmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskAttachments extends ListRecords
{
    protected static string $resource = TaskAttachmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Task Attachment'),
        ];
    }
}
