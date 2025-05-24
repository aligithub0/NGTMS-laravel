<x-filament::page>
    <div class="w-full max-w-[1920px] mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-6 w-full">
            <!-- Left Sidebar - 30% width -->
            <div class="w-1/2 md:w-[30%] min-w-[30%] space-y-4">
                <!-- Ticket Card -->
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <!-- Ticket Header -->
                    <div class="flex items-start justify-between mb-4">
                        <h2 class="text-xl font-bold dark:text-white">{{ $this->record->subject }}</h2>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                 {{ $this->record->priority ? 'bg-'.$this->record->priority->color.'-100 text-'.$this->record->priority->color.'-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $this->record->priority->name ?? 'Normal' }}
                        </span>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-3">
                        <span class="text-gray-500 dark:text-gray-400 mr-2">Ticket Status:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $this->record->ticketStatus ? 'bg-'.$this->record->ticketStatus->color.'-100 text-'.$this->record->ticketStatus->color.'-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $this->record->ticketStatus->name ?? 'No Status' }}
                        </span>
                    </div>

                    <!-- Ticket Details -->
                    <div class="space-y-4 text-sm">
                        <!-- Detail Item -->
                        <div class="flex items-center">
                            <x-heroicon-o-ticket class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" />
                            <span class="text-gray-500 dark:text-gray-400 mr-2">Ticket ID:</span>
                            <span class="font-medium dark:text-white">#{{ $this->record->id ?? 'N/A' }}</span>
                        </div>

                        <!-- Detail Item -->
                        <div class="flex items-center">
                            <x-heroicon-o-user class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" />
                            <span class="text-gray-500 dark:text-gray-400 mr-2">Created By:</span>
                            <span class="font-medium dark:text-white">{{ $this->record->createdBy->name ?? 'Unknown' }}</span>
                        </div>

                        <!-- Detail Item -->
                        <div class="flex items-center">
                            <x-heroicon-o-user-circle class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" />
                            <span class="text-gray-500 dark:text-gray-400 mr-2">Assigned To:</span>
                            <span class="font-medium dark:text-white">{{ $this->record->assignedTo->name ?? 'Unassigned' }}</span>
                        </div>

                        <!-- Detail Item -->
                        <div class="flex items-center">
                            <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" />
                            <span class="text-gray-500 dark:text-gray-400 mr-2">Created On:</span>
                            <span class="font-medium dark:text-white">
                                {{ $this->record->created_at->format('M d, Y H:i') }}
                            </span>
                        </div>

                        <!-- Last Updated -->
                        <div class="flex items-center">
                            <x-heroicon-o-clock class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" />
                            <span class="text-gray-500 dark:text-gray-400 mr-2">Last Updated:</span>
                            <span class="font-medium dark:text-white">
                                {{ $this->record->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Info Card -->
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <x-heroicon-o-user-group class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" />
                        Customer Information
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium dark:text-white truncate">{{ $this->record->createdBy->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="font-medium dark:text-white">{{ $this->record->createdBy->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Organization</p>
                            <p class="font-medium dark:text-white">{{ $this->record->createdBy->company->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - 70% width -->
            <div class="w-full md:w-[70%] space-y-5">
                <!-- Compose Reply -->
                <form wire:submit="submitReply">
                    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                        {{ $this->form }}
                        <div class="flex justify-end mt-4">
                            <x-filament::button type="submit" size="lg">
                                Send Reply
                            </x-filament::button>
                        </div>
                    </div>
                </form>
                
                <!-- Reply History -->
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h3 class="font-medium text-lg mb-4 dark:text-white">Reply History</h3>
                    @forelse ($this->record->replies->sortByDesc('created_at') as $reply)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <x-heroicon-o-user class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-medium dark:text-white">{{ $reply->user->name ?? 'System' }}</span>
                                            @if($reply->is_contact_notify)
                                                <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-200">
                                                    Customer
                                                </span>
                                            @else
                                                <span class="ml-2 text-xs bg-gray-100 text-gray-800 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-gray-200">
                                                    Internal
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $reply->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="prose dark:prose-invert max-w-none mt-2">
                                        {!! Str::markdown($reply->message) !!}
                                    </div>
                                    @if($reply->attachment_path)
                                        <div class="mt-3">
                                            <a href="{{ Storage::url($reply->attachment_path) }}" 
                                               target="_blank"
                                               class="inline-flex items-center text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300">
                                                <x-heroicon-o-paper-clip class="w-4 h-4 mr-1" />
                                                {{ basename($reply->attachment_path) }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <x-heroicon-o-inbox class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500" />
                            <h4 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No replies yet</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Be the first to reply to this ticket.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament::page>