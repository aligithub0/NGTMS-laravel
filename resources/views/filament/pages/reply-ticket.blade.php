<x-filament::page>
    <div class="w-full max-w-[1920px] mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-8 w-full">
            <!-- Left Sidebar - 30% width -->
            <div class="w-[30%] md:w-[30%] min-w-[30%] space-y-6">
                <!-- Ticket Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <!-- Ticket Header -->
                    <div class="flex items-start justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $this->record->subject }}</h2>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                 {{ $this->record->priority ? 'bg-'.$this->record->priority->color.'-100 text-'.$this->record->priority->color.'-800 dark:bg-'.$this->record->priority->color.'-900 dark:text-'.$this->record->priority->color.'-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                            {{ $this->record->priority->name ?? 'Normal' }}
                        </span>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-300 font-medium">Status:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $this->record->ticketStatus ? 'bg-'.$this->record->ticketStatus->color.'-100 text-'.$this->record->ticketStatus->color.'-800 dark:bg-'.$this->record->ticketStatus->color.'-900 dark:text-'.$this->record->ticketStatus->color.'-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                {{ $this->record->ticketStatus->name ?? 'No Status' }}
                            </span>
                        </div>
                    </div>

                    <!-- Ticket Details - Horizontal Layout -->
                    <div class="">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-sm">
                            <!-- Ticket ID -->
                            <div class="flex flex-col p-3 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center mb-1">
                                    <x-heroicon-o-ticket class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Ticket ID</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-white">#{{ $this->record->id ?? 'N/A' }}</span>
                            </div>

                            <!-- Created By -->
                            <div class="flex flex-col p-3 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center mb-1">
                                    <x-heroicon-o-user class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Created By</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-white truncate">{{ $this->record->createdBy->name ?? 'Unknown' }}</span>
                            </div>

                            <!-- Assigned To -->
                            <div class="flex flex-col p-3 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center mb-1">
                                    <x-heroicon-o-user-circle class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Assigned To</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-white truncate">{{ $this->record->assignedTo->name ?? 'Unassigned' }}</span>
                            </div>

                            <!-- Created On -->
                            <div class="flex flex-col p-3 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center mb-1">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Created On</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->created_at->format('M d, Y') }}</span>
                            </div>

                            <!-- Last Updated -->
                            <div class="flex flex-col p-3 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center mb-1">
                                    <x-heroicon-o-clock class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Last Updated</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Info Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-5 flex items-center">
                        <x-heroicon-o-user-group class="w-6 h-6 mr-2 text-primary-500 dark:text-primary-400" />
                        Customer Information
                    </h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <p class="text-xs text-blue-600 dark:text-blue-300">Email</p>
                            <p class="font-medium text-gray-800 dark:text-white truncate">{{ $this->record->createdBy->email ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <p class="text-xs text-blue-600 dark:text-blue-300">Phone</p>
                            <p class="font-medium text-gray-800 dark:text-white">{{ $this->record->createdBy->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <p class="text-xs text-blue-600 dark:text-blue-300">Organization</p>
                            <p class="font-medium text-gray-800 dark:text-white">{{ $this->record->createdBy->company->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - 70% width -->
            <div class="w-full md:w-[70%] space-y-6">
                <!-- Compose Reply -->
                <form wire:submit="submitReply">
                    <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-primary-200 dark:border-primary-800">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-5 flex items-center">
                            <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6 mr-2 text-primary-500 dark:text-primary-400" />
                            Compose Reply
                        </h3>
                        {{ $this->form }}
                        <div class="flex justify-end mt-6 space-x-3">
                            <x-filament::button type="submit" size="lg" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700">
                                Send Reply
                            </x-filament::button>
                        </div>
                    </div>
                </form>
                
                <!-- Reply History -->
                <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-4 flex items-center ">
                        <x-heroicon-o-chat-bubble-bottom-center-text class="w-6 h-6 mr-2  text-primary-500 dark:text-primary-400" />
                        Reply History
                    </h3>
                    
                    <div class="space-y-6">
                        @forelse ($this->record->replies->sortByDesc('created_at') as $reply)
                            <div class="relative group">
                                <div class="absolute -left-3 top-0 h-full w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                <div class="pl-6">
                                    <div class="border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 hover:border-primary-200 dark:hover:border-primary-800 transition-colors">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white">
                                                    @if($reply->user->profile_photo_url ?? false)
                                                        <img src="{{ $reply->user->profile_photo_url }}" class="w-full h-full rounded-full" alt="User avatar">
                                                    @else
                                                        <x-heroicon-o-user class="w-5 h-5" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center">
                                                        <span class="font-semibold text-gray-800 dark:text-white">{{ $reply->user->name ?? 'System' }}</span>
                                                        @if($reply->is_contact_notify)
                                                            
                                                        @else
                                                            <span class="ml-2 text-xs bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-200">
                                                                Internal
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                                        {{ $reply->created_at->format('M d, Y h:i A') }}
                                                    </span>
                                                </div>
                                                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                                    {!! Str::markdown($reply->message) !!}
                                                </div>
                                                @if($reply->attachment_path)
                                                    <div class="mt-3">
                                                        <a href="{{ Storage::url($reply->attachment_path) }}" 
                                                           target="_blank"
                                                           class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 bg-primary-50 dark:bg-primary-900/30 px-3 py-1.5 rounded-lg">
                                                            <x-heroicon-o-paper-clip class="w-4 h-4 mr-2" />
                                                            {{ basename($reply->attachment_path) }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 px-4">
                                
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">No replies yet</h4>
                                <p class="mt-2 text-gray-500 dark:text-gray-400 max-w-md mx-auto">Be the first to reply to this ticket. Your response will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>