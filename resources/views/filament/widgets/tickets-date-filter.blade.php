<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit.prevent="updateFilters">
            <div class="mb-4">
                {{ $this->form }}
            </div>

            <div class="flex justify-end">
                <x-filament::button type="submit" size="sm">
                    Apply Filters
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
