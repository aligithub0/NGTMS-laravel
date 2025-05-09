<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;

class FilamentMacrosServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        DeleteAction::macro('safeDelete', function () {
            return $this
                ->action(function ($record, DeleteAction $action) {
                    try {
                        // Attempt to delete the record
                        $record->delete();

                        // Show success notification if deletion is successful
                        Notification::make()
                            ->title('Deleted successfully')
                            ->success()
                            ->send();
                    } catch (QueryException $e) {
                        // Check for foreign key constraint violation (Error Code 1451)
                        if ($e->getCode() == 23000 && str_contains($e->getMessage(), '1451')) {
                            // Display custom error message for foreign key violation
                            Notification::make()
                                ->title('Deletion Failed')
                                ->body('This record is linked to other data and cannot be deleted.')
                                ->danger()
                                ->send();
                        } else {
                            // If there’s another error, let Laravel handle it
                            throw $e;
                        }
                    }
                });
        });
    }
}
