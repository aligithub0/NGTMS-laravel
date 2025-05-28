<?php

namespace App\Filament\Resources\TimesheetStatusResource\Pages;

use App\Filament\Resources\TimesheetStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimesheetStatus extends EditRecord
{
    protected static string $resource = TimesheetStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
