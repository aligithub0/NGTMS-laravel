<x-filament::page>
    <div class="w-full max-w-[1920px] mx-auto px-4"> <!-- Container with max width and padding -->
        <div class="flex flex-col md:flex-row gap-4 w-full">
            <!-- Left Sidebar - 25% width -->
            <!-- Left Sidebar - 30% width -->
<div class="w-1/3 md:w-[30%] min-w-[30%] space-y-4">
    <!-- Ticket Card -->
    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <!-- Ticket Header -->
        <div class="flex items-start justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white truncate">
                {{ $ticket->subject ?? 'No Subject' }}
            </h2>
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                      @if($ticket->priority->name ?? '' === 'High') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                      @elseif($ticket->priority->name ?? '' === 'Medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                      @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                {{ $ticket->priority->name ?? 'Normal' }}
            </span>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                      @if($ticket->ticketStatus->name ?? '' === 'Open') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                      @elseif($ticket->ticketStatus->name ?? '' === 'Closed') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                      @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @endif">
                {{ $ticket->ticketStatus->name ?? 'No Status' }}
            </span>
        </div>

        <!-- Ticket Details -->
        <div class="space-y-4 text-sm">
            <!-- Detail Item -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="text-gray-500 dark:text-gray-400 mr-2">Ticket ID:</span>
                <span class="font-medium dark:text-white">#{{ $ticket->id ?? 'N/A' }}</span>
            </div>

            <!-- Detail Item -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-gray-500 dark:text-gray-400 mr-2">Created By:</span>
                <span class="font-medium dark:text-white">{{ $ticket->createdBy->name ?? 'Unknown' }}</span>
            </div>

            <!-- Detail Item -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span class="text-gray-500 dark:text-gray-400 mr-2">Assigned To:</span>
                <span class="font-medium dark:text-white">{{ $ticket->assignedTo->name ?? 'Unassigned' }}</span>
            </div>

            <!-- Detail Item -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-gray-500 dark:text-gray-400 mr-2">Created On:</span>
                <span class="font-medium dark:text-white">
                    @if($ticket->created_at)
                        {{ $ticket->created_at->format('M d, Y H:i') }}
                    @else
                        Date not available
                    @endif
                </span>
            </div>

            <!-- Last Updated -->
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-gray-500 dark:text-gray-400 mr-2">Last Updated:</span>
                <span class="font-medium dark:text-white">
                    @if($ticket->updated_at)
                        {{ $ticket->updated_at->diffForHumans() }}
                    @else
                        Never
                    @endif
                </span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Quick Actions</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-md dark:bg-blue-900/50 dark:hover:bg-blue-800 dark:text-blue-200">
                    Change Status
                </button>
                <button class="px-3 py-1 text-sm bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                    Reassign
                </button>
            </div>
        </div>
    </div>
    
    <!-- Customer Info Card (optional) -->
    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Customer Information
        </h3>
        <div class="space-y-3 text-sm">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Email</p>
                <p class="font-medium dark:text-white truncate">customer@example.com</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Phone</p>
                <p class="font-medium dark:text-white">+1 (555) 123-4567</p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400">Organization</p>
                <p class="font-medium dark:text-white">Acme Inc.</p>
            </div>
            <button class="mt-3 w-full px-3 py-2 text-sm bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                View Full Profile
            </button>
        </div>
    </div>
</div>
            <!-- Right Panel - 75% width -->
            <div class="w-full md:w-[75%] space-y-5">
                <!-- Compose Reply -->
                <form wire:submit="submitReply">
                    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                       
                        {{ $this->form }}
                        <x-filament::button type="submit" class="mt-2">
                            Send Reply
                        </x-filament::button>
                    </div>
                </form>
                
                <!-- Reply History -->
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h3 class="font-medium mb-3 dark:text-white">Reply History</h3>
                    @forelse ($ticket->replies->sortByDesc('created_at') as $reply)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
                            <div class="flex items-start gap-3">
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
                                            @if($reply->created_at)
                                                {{ $reply->created_at->diffForHumans() }}
                                            @else
                                                Time not available
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-sm mt-1 dark:text-gray-300">{{ $reply->message }}</p>
                                    @if($reply->attachment_path)
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($reply->attachment_path) }}" target="_blank" class="text-sm text-primary-500 hover:underline dark:text-primary-400">
                                                View Attachment
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No replies yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament::page>