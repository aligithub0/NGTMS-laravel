<?php

namespace App\Filament\Resources\DesignationsResource\Pages;

use App\Filament\Resources\DesignationsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDesignations extends CreateRecord
{
    protected static string $resource = DesignationsResource::class;

    public function getTitle(): string
    {
        return 'Create Designation';
    }
}
