<?php

namespace App\Filament\Resources\TaskAttachmentsResource\Pages;

use App\Filament\Resources\TaskAttachmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskAttachments extends EditRecord
{
    protected static string $resource = TaskAttachmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
