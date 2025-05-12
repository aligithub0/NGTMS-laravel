<?php

namespace App\Filament\Resources\TimesheetActivitiesResource\Pages;

use App\Filament\Resources\TimesheetActivitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimesheetActivities extends ListRecords
{
    protected static string $resource = TimesheetActivitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Timesheet Activities'),
        ];
    }
}
