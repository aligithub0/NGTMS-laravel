<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        
        <div class="flex justify-end gap-4 mt-6">
            <x-filament::button 
                type="button"
                color="gray" 
                wire:click="cancel"
                tag="a"
                href="{{ url()->previous() }}"
            >
                Cancel
            </x-filament::button>
            
            <x-filament::button type="submit">
                Save Changes
            </x-filament::button>
        </div>
    </form>
</x-filament::page>