<x-filament::page>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <div class="w-full max-w-[1920px] mx-auto ">
        <div class="flex flex-col md:flex-row gap-8 w-full">
            <!-- Left Sidebar - 70% width -->
            <div class="w-full md:w-[70%] space-y-6">
                <!-- Compose Reply -->
                <form wire:submit="submitReply">
                    <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-primary-200 dark:border-primary-800">
                        <div class="space-y-3">
                            <div class="space-y-1">
                                <!-- To Recipients -->
                                <div class="flex w-full items-center">
                                <div class="w-full flex items-center">
                                    <label style="padding-right:42px;" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">To:</label>
                                    <input 
                                        type="email" 
                                        wire:model="replyData.to_recipients" 
                                        required
                                        class="flex-1 font-small  border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                        placeholder="Recipient email"
                                    style="font-size:13px; padding:3px;">
                                </div>
                            </div>

                                <div class="space-y-1">
    <!-- CC Recipients -->
    <div class="flex w-full items-center">
        <div class="w-full flex items-center">
            <label style="padding-right:38px;" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">CC:</label>
            <input 
                type="email" 
                wire:model="replyData.cc_recipients"
                class="flex-1 font-small  border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="CC email"
                style="font-size:13px; padding:3px;">
        </div>
    </div>

    <!-- BCC Recipients -->
    <div class="flex w-full items-center">
        <div class="w-full flex items-center">
            <label style="padding-right:29px;" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">BCC:</label>
            <input 
                type="email" 
                wire:model="replyData.bcc"
                class="flex-1 font-small  border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="BCC email"
                style="font-size:13px; padding:3px;">
        </div>
    </div>

    <!-- Subject -->
    <div class="flex w-full items-center">
        <div class="w-full flex items-center">
            <label  class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">Subject:</label>
            <input 
                type="text" 
                wire:model="replyData.subject" 
                required 
                maxlength="255"
                class="flex-1 font-small  border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="Subject"
                style="font-size:13px; padding:3px;">
        </div>
    </div>

<div class="w-full max-w-[200px]" x-data x-init="
    const quill = new Quill($refs.quillEditor, {
        theme: 'snow',
        placeholder: 'Type your reply here...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'code-block'],
                ['clean']
            ]
        }
    });

    quill.on('text-change', () => {
        @this.set('replyData.message', quill.root.innerHTML);
    });
"
wire:ignore>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>

    {{-- The editable div --}}
    <div x-ref="quillEditor"
         class="min-h-[150px] bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg p-3 border border-gray-300 dark:border-gray-600 shadow-sm">
    </div>
</div>


    <!-- Internal Notes -->
    <div class="w-full">
        <div class="flex items-center mb-1">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">Internal Notes:</label>
        </div>
        <textarea 
            wire:model="replyData.internal_notes" 
            rows="3"
            class="w-full font-small rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
            placeholder="Add any internal notes here (not visible to customer)"
            style="font-size:13px;"></textarea>
    </div>

    <!-- Notify Customer Checkbox -->
    <div class="flex items-center">
        <input 
            type="checkbox" 
            wire:model="replyData.notify_customer" 
            id="notify_customer"
            class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:checked:bg-primary-500">
        <label 
            for="notify_customer" 
            class="ml-2 block text-sm text-gray-900 dark:text-white"
            style="font-size:13px;">Notify customer</label>
    </div>

    <!-- Attachment -->
    <div class="w-full">
        <div class="flex items-center mb-1">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">Attachment:</label>
        </div>
        <div x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col w-full border-2 border-dashed rounded-lg cursor-pointer hover:border-primary-300 dark:hover:border-primary-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <x-heroicon-o-cloud-arrow-up class="w-10 h-10 mb-3 text-gray-400 dark:text-gray-500" />
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400" style="font-size:13px;">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" style="font-size:11px;">
                            PDF, DOC, XLS, or images (max. 10MB)
                        </p>
                    </div>
                    <input 
                        type="file" 
                        wire:model="replyData.attachment_path" 
                        class="hidden"
                        accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                </label>
            </div>
            <!-- Progress Bar -->
            <div x-show="isUploading" class="w-full mt-2">
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-primary-500" x-bind:style="`width: ${progress}%`"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" style="font-size:11px;" x-text="`Uploading... ${progress}%`"></p>
            </div>
            <!-- File Preview -->
            <div wire:loading.remove wire:target="replyData.attachment_path" class="mt-2">
                <template wire:if="replyData.attachment_path">
                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <button 
                            type="button" 
                            wire:click="removeAttachment"
                            class="text-red-500 hover:text-red-700 dark:hover:text-red-400">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
                            </div>
                        </div>
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
                        <!-- Inside your reply history section -->
                        @forelse ($this->record->replies->sortByDesc('created_at') as $reply)
                            <div class="relative group">
                                <!-- Timeline indicator (gradient line) -->
                                <div class="absolute -left-3 top-0 h-full w-0.5 bg-gradient-to-b from-gray-300 via-gray-200 to-gray-300 dark:from-gray-600 dark:via-gray-700 dark:to-gray-600"></div>
                                
                                <div class="pl-6">
                                    <!-- Reply Card -->
                                    <div class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl p-6 hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-200 shadow-sm hover:shadow-md mb-6">
                                        <div class="flex items-start gap-4">
                                            <!-- User Avatar -->
                                            <div class="flex-shrink-0 relative">
                                                <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full blur-sm opacity-75 group-hover:opacity-100 transition-opacity duration-200"></div>
                                                <div class="relative w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white ring-2 ring-white dark:ring-gray-800">
                                                    @if($reply->user->profile_photo_url ?? false)
                                                        <img src="{{ $reply->user->profile_photo_url }}" class="w-full h-full rounded-full object-cover" alt="User avatar">
                                                    @else
                                                        <x-heroicon-o-user class="w-5 h-5" />
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Reply Content -->
                                            <div class="flex-1 min-w-0 space-y-4">
                                                <!-- Header (User + Timestamp) -->
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $reply->user->name ?? 'System' }}</span>
                                                        @if($reply->is_contact_notify)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                                <x-heroicon-o-lock-closed class="w-3 h-3 mr-1" /> Internal
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                                        <x-heroicon-o-clock class="w-3 h-3 inline mr-1" />
                                                        {{ $reply->created_at->format('M d, Y h:i A') }}
                                                    </span>
                                                </div>
                                                
                                                <!-- Subject -->
                                                @if($reply->subject)
                                                <div class="flex items-start text-sm text-gray-700 dark:text-gray-300">
                                                    <x-heroicon-o-tag class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-gray-400 dark:text-gray-500" />
                                                    <span class="font-medium">Subject:</span>
                                                    <span class="ml-1">{{ $reply->subject }}</span>
                                                </div>
                                                @endif
                                                
                                                <!-- Recipients -->
                                                @if($reply->to_recipients || $reply->cc_recipients)
                                                <div class="space-y-1 text-sm">
                                                    @if($reply->to_recipients)
                                                    <div class="flex items-start text-gray-700 dark:text-gray-300">
                                                        <x-heroicon-o-envelope class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-gray-400 dark:text-gray-500" />
                                                        <span class="font-medium">To:</span>
                                                        <span class="ml-1">{{ $reply->to_recipients }}</span>
                                                    </div>
                                                    @endif
                                                    @if($reply->cc_recipients)
                                                    <div class="flex items-start text-gray-700 dark:text-gray-300">
                                                        <x-heroicon-o-envelope class="flex-shrink-0 w-4 h-4 mt-0.5 mr-2 text-gray-400 dark:text-gray-500" />
                                                        <span class="font-medium">CC:</span>
                                                        <span class="ml-1">{{ $reply->cc_recipients }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endif
                                                
                                                <!-- Main Message -->
                                                <div class="prose dark:prose-invert max-w-none p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                                                    {!! Str::markdown($reply->message) !!}
                                                </div>

                                                <!-- Notes Section (Conditional) -->
                                                @if($reply->internal_notes)
                                                <div class="relative pl-10 mb-6">
                                                    <!-- Notes Indicator (Smaller line) -->
                                                    <div class="absolute left-0 top-0 h-full w-0.5 bg-gray-200 dark:bg-gray-700 ml-[14px]"></div>
                                                    
                                                    <!-- Notes Card -->
                                                    <div class="border border-yellow-200 dark:border-yellow-800 bg-yellow-50/80 dark:bg-yellow-900/20 rounded-lg p-4 shadow-xs">
                                                        <div class="flex items-start gap-3">
                                                            <!-- Notes Icon -->
                                                            <div class="flex-shrink-0 mt-0.5">
                                                                <div class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center text-yellow-600 dark:text-yellow-300">
                                                                    <x-heroicon-o-document-text class="w-4 h-4" />
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Notes Content -->
                                                            <div class="flex-1 min-w-0">
                                                                <div class="flex items-center justify-between mb-1">
                                                                    <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Internal Notes</span>
                                                                    <span class="text-xs text-yellow-600/80 dark:text-yellow-400/80">
                                                                        {{ $reply->updated_at->diffForHumans() }}
                                                                    </span>
                                                                </div>
                                                                <div class="text-sm text-yellow-700 dark:text-yellow-300 whitespace-pre-wrap">{{ $reply->internal_notes }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <!-- Attachment -->
                                                @if($reply->attachment_path)
                                                <div class="mt-3">
                                                    <a href="{{ Storage::url($reply->attachment_path) }}" 
                                                    target="_blank"
                                                    class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 bg-primary-50/70 dark:bg-primary-900/30 px-3 py-2 rounded-lg border border-primary-100 dark:border-primary-800 hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                                                        <x-heroicon-o-paper-clip class="w-4 h-4 mr-2" />
                                                        <span class="truncate max-w-xs">{{ basename($reply->attachment_path) }}</span>
                                                        <x-heroicon-o-arrow-down-tray class="w-4 h-4 ml-2 opacity-70" />
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="text-center py-12 px-4">
                                <div class="mx-auto max-w-md">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                        <x-heroicon-o-chat-bubble-left-right class="w-8 h-8 text-gray-500 dark:text-gray-400" />
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No replies yet</h4>
                                    <p class="text-gray-500 dark:text-gray-400">Be the first to reply to this ticket. Your response will appear here.</p>
                                    <div class="mt-4">
                                        <x-heroicon-o-arrow-long-down class="w-6 h-6 mx-auto text-gray-400 dark:text-gray-500 animate-bounce" />
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
         
            <!-- Right Panel - 30% width -->
            <div class="w-[35%] md:w-[30%] min-w-[30%] space-y-6" style="width:32% !important">
                <!-- Ticket Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <!-- Ticket Header -->
                    <div class="flex items-start justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $this->record->title }}</h2>
                    </div>

                    <!-- Ticket Details - Horizontal Layout -->
                    <div class="">
                        <div class="grid grid-cols-1 md:grid-cols-5 text-sm">

                        <!-- Purpose -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Purpose: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->purposeType->name }}</span>

                                </div>
                            </div>

                            <!-- Message -->
                        <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg" x-data="{ showTooltip: false }">
                                <div class="flex items-center">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Message: </span>
                                    <div class="relative">
                                        <!-- Truncated preview text -->
                                        <span class="font-semibold text-gray-800 dark:text-white truncate cursor-pointer"
                                            @mouseenter="showTooltip = true" 
                                            @mouseleave="showTooltip = false">
                                            @php
                                                $words = preg_split('/\s+/', strip_tags($this->record->message));
                                                $preview = implode(' ', array_slice($words, 0, 3));
                                                if (count($words) > 3) { $preview .= '...'; }
                                            @endphp
                                            {{ $preview }}
                                        </span>
                                        
                                        <!-- Standard colored tooltip with plain text -->
                                        <div x-show="showTooltip" x-transition
                                            class="absolute z-50 w-64 p-3 mt-2 text-md font-normal text-black bg-white  dark:bg-gray-600 rounded-md shadow-lg whitespace-pre-line">
                                            @php
                                                // Convert to plain text with preserved line breaks
                                                $plainText = html_entity_decode(strip_tags($this->record->message));
                                                // Normalize whitespace and line breaks
                                                $plainText = preg_replace('/\s+/', ' ', $plainText);
                                                $plainText = str_replace(["\r\n", "\n", "\r"], "<br>", $plainText);
                                            @endphp
                                            {!! $plainText !!}
                                            
                                            <!-- Tooltip arrow -->
                                            <div class="absolute -top-1 left-4 w-2 h-2 bg-gray-800 dark:bg-gray-600 transform rotate-45"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    

                            <!-- Ticket ID -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-ticket class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Ticket ID: </span>
                                    <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->ticket_id ?? 'N/A' }}</span>
                                </div>
                                
                            </div>

                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-ticket class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Status: </span>
                                    <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->ticketStatus->name ?? 'No Status' }}</span>
                                </div>
                                
                            </div>

                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-ticket class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Priority: </span>
                                    <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->priority->name }}</span>
                                </div>
                                
                            </div>

                            <!-- SLA -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">SLA: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->SlaConfiguration->name }}</span>

                                </div>
                            </div>


                            <!-- Response Time -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Response Time: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->response_time }}</span>

                                </div>
                            </div>

                            <!-- Resoltion Time -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Resolution Time: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->resolution_time }}</span>

                                </div>
                            </div>


                            <!-- Assigned To -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-user-circle class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Assigned To: </span>
                                <span class="font-semibold text-gray-800 dark:text-white truncate">{{ $this->record->assignedTo->name ?? 'Unassigned' }}</span>

                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-user class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Created By: </span>
                                    <span class="font-semibold text-gray-800 dark:text-white truncate">{{ $this->record->createdBy->name ?? 'Unknown' }}</span>

                                </div>
                            </div>

                            

                            <!-- Created On -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Created On: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->created_at->format('M d, Y') }}</span>

                                </div>
                            </div>

                            <!-- Last Updated -->
                            <div class="flex flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                                <div class="flex items-center ">
                                    <x-heroicon-o-clock class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 px-2">Last Updated:</span>
                                    <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->updated_at->diffForHumans() }}</span>
                                </div>
                                
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
                    <div class="">
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
        </div>
    </div>

  
</x-filament::page>