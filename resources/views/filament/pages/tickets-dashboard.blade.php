<x-filament::page>
    {{-- Header with Filters --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-xl font-bold"></h2>
        
        {{-- Filters with spacing only between elements --}}
        <div class="">
            <select wire:model="status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                <option value="">All Status</option>
                <option value="unassigned">Unassigned</option>
                <option value="assigned">Assigned</option>
            </select>
            
            <input type="date" wire:model="fromDate" placeholder="mm/dd/yyyy" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
            
            <input type="date" wire:model="toDate" placeholder="mm/dd/yyyy" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
            
            <button wire:click="applyFilters" class="text-sm inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Apply
            </button>
        </div>
    </div>

    {{-- 1. Top Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        @livewire(\App\Filament\Widgets\TicketsOverview::class)
    </div>

    {{-- 2. Charts Row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        @livewire(\App\Filament\Widgets\TicketsByStatusChart::class)
        @livewire(\App\Filament\Widgets\TicketsByPriorityChart::class)
    </div>

    {{-- 3. Full-width Table --}}
    <div class="w-full">
        @livewire(\App\Filament\Widgets\RecentTicketsTable::class)
    </div>
</x-filament::page>