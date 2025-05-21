<x-filament::page>
        

    {{-- 1. Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        @livewire(\App\Filament\Widgets\TicketsOverview::class)
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
