<x-filament::page>
    <form wire:submit.prevent="update">
        {{ $this->form }}

        <x-filament-actions::modals />
    </form>
</x-filament::page>