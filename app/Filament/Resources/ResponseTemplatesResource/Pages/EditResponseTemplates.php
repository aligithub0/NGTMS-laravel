<?php

namespace App\Filament\Resources\ResponseTemplatesResource\Pages;

use App\Filament\Resources\ResponseTemplatesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponseTemplates extends EditRecord
{
    protected static string $resource = ResponseTemplatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
