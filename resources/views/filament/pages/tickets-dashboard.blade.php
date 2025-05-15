<x-filament::page>
    {{-- Header with Filter Button --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        

        {{-- Filter Icon Button --}}
        <button 
            wire:click="$set('showFilterModal', true)" 
            class="ml-auto text-gray-600 hover:text-primary-600"
            title="Filter"
        >
            <x-heroicon-o-funnel class="w-6 h-2" />
        </button>
    </div>

    {{-- 1. Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        @livewire(\App\Filament\Widgets\TicketsOverview::class)
    </div>

    {{-- 2. Charts --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="h-full">
            @livewire(\App\Filament\Widgets\TicketsByStatusChart::class)
        </div>
        <div class="h-full">
            @livewire(\App\Filament\Widgets\TicketsBySLAChart::class)
        </div>
        <div class="h-full">
            @livewire(\App\Filament\Widgets\TicketsByPriorityChart::class)
        </div>
    </div>

    {{-- 3. Tickets Table --}}
    <div class="w-full">
        @livewire(\App\Filament\Widgets\RecentTicketsTable::class)
    </div>

    {{-- Filter Modal --}}
    <x-filament::modal 
        id="filterModal" 
        width="md" 
        wire:model.defer="showFilterModal"
    >
        <x-slot name="header">
            Filter Tickets
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <label>Status</label>
                    <select wire:model.defer="status" class="w-full border-gray-300 rounded-md">
                        <option value="">All Status</option>
                        <option value="unassigned">Unassigned</option>
                        <option value="assigned">Assigned</option>
                    </select>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label>From Date</label>
                        <input type="date" wire:model.defer="fromDate" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex-1">
                        <label>To Date</label>
                        <input type="date" wire:model.defer="toDate" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-filament::button color="gray" wire:click="$set('showFilterModal', false)">
                Cancel
            </x-filament::button>

            <x-filament::button wire:click="applyFilters">
                Apply Filters
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament::page>
