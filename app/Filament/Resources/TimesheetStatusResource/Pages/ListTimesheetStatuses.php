<?php

namespace App\Filament\Resources\TimesheetStatusResource\Pages;

use App\Filament\Resources\TimesheetStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimesheetStatuses extends ListRecords
{
    protected static string $resource = TimesheetStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Timesheet Status';
    }
}
