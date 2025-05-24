<?php

namespace App\Filament\Resources\TimesheetActivitiesResource\Pages;

use App\Filament\Resources\TimesheetActivitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimesheetActivities extends EditRecord
{
    protected static string $resource = TimesheetActivitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->safeDelete(),
        ];
    }
}
