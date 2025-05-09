<?php

namespace App\Filament\Resources\ProjectTypesResource\Pages;

use App\Filament\Resources\ProjectTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectTypes extends CreateRecord
{
    protected static string $resource = ProjectTypesResource::class;

    public function getTitle(): string
    {
        return 'Create Project Type';
    }
}
