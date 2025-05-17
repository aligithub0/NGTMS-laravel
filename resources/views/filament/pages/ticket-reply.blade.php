<x-filament::page>
    <div class="space-y-6">
        {{-- Ticket Header --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold">Ticket #{{ $this->ticket->id ?? 'N/A' }}</h1>
                    <p class="text-lg text-gray-600">{{ $this->ticket->title ?? 'No title' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">
                        Created: {{ optional($this->ticket->created_at)->format('M d, Y H:i') ?? 'N/A' }}
                    </p>
                    <div class="flex items-center gap-2 mt-1">
                        @if($this->ticket->priority)
                            <span class="px-2 py-1 text-xs rounded-md"
                                  style="background-color: {{ $this->ticket->priority->color ?? '#6b7280' }}; color: white;">
                                {{ $this->ticket->priority->name ?? 'N/A' }}
                            </span>
                        @endif
                        @if($this->ticket->ticketStatus)
                            <span class="px-2 py-1 text-xs bg-gray-100 rounded-md">
                                {{ $this->ticket->ticketStatus->name ?? 'N/A' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Form --}}
        <form wire:submit.prevent="save">
            {{ $this->form }}
            
            <div class="flex justify-end gap-4 mt-6">
                <x-filament::button 
                    type="button"
                    color="gray" 
                    tag="a"
                    href="{{ url()->previous() }}"
                >
                    Cancel
                </x-filament::button>
                
                <x-filament::button type="submit">
                    Submit Reply
                </x-filament::button>
            </div>
        </form>

        {{-- Previous Replies --}}
        @if($this->ticket->replies->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Reply History</h2>
                <div class="space-y-4">
                    @foreach($this->ticket->replies()->latest()->get() as $reply)
                        <div class="border rounded-lg p-4 @if($reply->is_reply_from_contact) bg-blue-50 @endif">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-medium">{{ $reply->users->name ?? 'System' }}</span>
                                    <span class="text-sm text-gray-500 ml-2">
                                        {{ optional($reply->created_at)->format('M d, Y H:i') ?? 'N/A' }}
                                    </span>
                                    @if($reply->is_reply_from_contact)
                                        <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">From Contact</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($reply->priority)
                                        <span class="px-2 py-1 text-xs rounded-md" 
                                              style="background-color: {{ $reply->priority->color ?? '#6b7280' }}; color: white;">
                                            {{ $reply->priority->name ?? 'N/A' }}
                                        </span>
                                    @endif
                                    @if($reply->replyType)
                                        <span class="px-2 py-1 text-xs bg-gray-100 rounded-md">
                                            {{ $reply->replyType->name ?? 'N/A' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                <h3 class="font-medium">{{ $reply->subject ?? 'No subject' }}</h3>
                                <div class="mt-2 prose max-w-none">
                                    {!! \Illuminate\Support\Str::markdown($reply->message ?? 'No message') !!}
                                </div>
                            </div>
                            
                            @if($reply->attachment_path && is_array(json_decode($reply->attachment_path)))
                                <div class="mt-3">
                                    <h4 class="text-sm font-medium mb-1">Attachments:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(json_decode($reply->attachment_path) as $attachment)
                                            @if($attachment)
                                                <a href="{{ Storage::url($attachment) }}" target="_blank" class="text-sm text-primary-600 hover:underline">
                                                    {{ basename($attachment) }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @if($reply->internal_notes)
                                <div class="mt-3 p-2 bg-gray-50 rounded">
                                    <h4 class="text-sm font-medium">Internal Notes:</h4>
                                    <div class="prose max-w-none text-sm">
                                        {!! \Illuminate\Support\Str::markdown($reply->internal_notes) !!}
                                    </div>
                                </div>
                            @endif
                            
                            @if($reply->external_notes)
                                <div class="mt-3 p-2 bg-yellow-50 rounded">
                                    <h4 class="text-sm font-medium">External Notes:</h4>
                                    <div class="prose max-w-none text-sm">
                                        {!! \Illuminate\Support\Str::markdown($reply->external_notes) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-filament::page>