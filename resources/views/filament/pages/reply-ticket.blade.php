<x-filament::page>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <div class="w-full max-w-[1920px] mx-auto ">
        <div class="flex flex-col md:flex-row gap-8 w-full">
            <!-- Left Sidebar - 70% width -->
            <div class="w-full md:w-[70%] space-y-6">
                <!-- Compose Reply -->

                <!-- Reply History -->
                <div id="myDiv" class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800"  style="height: 800px; overflow-y: scroll; ">
                        <!-- <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-4 flex items-center">
                            <x-heroicon-o-chat-bubble-bottom-center-text class="w-6 h-6 mr-2 text-primary-500 dark:text-primary-400" />
                            Reply History
                        </h3> -->
                        
                        <div class="space-y-6">
                            @forelse ($this->record->replies->sortBy('created_at') as $index => $reply)

                                @php
                                    $isEven = $index % 2 === 0;
                                    $isCurrentUser = $reply->user_id === auth()->id();
                                    $isSystem = !isset($reply->user);
                                @endphp
                                
                                <div class="relative group">
                                    <!-- Timeline indicator (centered) -->
                                    <div class="absolute left-1/2 -ml-px top-0 h-full w-0.5 bg-gradient-to-b from-gray-300 via-gray-200 to-gray-300 dark:from-gray-600 dark:via-gray-700 dark:to-gray-600"></div>
                                    
                                    <div class="relative pl-0">
                                        <!-- Reply Card - Alternating sides -->
                                        <div class="flex @if($isEven)  justify-start @else  justify-end @endif">
                                            <div class="@if($isEven) ml-8  @else mr-8 
                                            @endif w-full max-w-2xl">
                                                <div style = "background-color:#e3e3e3; @if(!$isEven) background-color:#ADD8E6;@endif"class="border border-gray-200 dark:border-gray-700  dark:bg-gray-800 rounded-xl px-6 py-4 hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-200 shadow-sm hover:shadow-md mb-6">
                                                    <div class="flex items-start gap-4 ">
                                                        <!-- User Avatar -->
                                                        <div class="flex-shrink-0 relative group">
                        {{-- Glowing gradient background --}}
                        <div class="absolute -inset-1 rounded-full blur-sm opacity-75 group-hover:opacity-100 transition-opacity duration-200
                            @if($isCurrentUser)
                                bg-gradient-to-r from-primary-500 to-primary-600
                            @else
                                bg-gradient-to-r from-gray-500 to-gray-600
                            @endif">
                        </div>

                        {{-- Avatar content --}}
                        <div class="relative w-10 h-10 rounded-full flex items-center justify-center text-white ring-2 ring-white dark:ring-gray-800
                            @if($isCurrentUser)
                                bg-gradient-to-r from-primary-500 to-primary-600
                            @else
                                bg-gradient-to-r from-gray-500 to-gray-600
                            @endif">

                            @if($reply->user->profile_photo_url ?? false)
                                <img src="{{ $reply->user->profile_photo_url }}" 
                                    class="w-full h-full rounded-full object-cover" 
                                    alt="{{ $reply->user->name ?? 'User avatar' }}">
                            @else
                                <x-heroicon-o-user class="w-5 h-5" />
                            @endif
                        </div>
                    </div>

                                    
                                    <!-- Reply Content -->
                                    <div class="flex-1 min-w-0 space-y-4 ">
                                        <!-- Header (User + Timestamp) -->
                                        <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-base text-gray-900 dark:text-white">
                                            {{ $reply->user->name ?? 'System' }}
                                            @if($reply->user && $reply->user->email)
                                                ({{ $reply->user->email }})
                                            @endif
                                        </span>
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


                                        <!-- Recipients -->
                                      
                                        
                                        <!-- Main Message -->
                                        <div class="prose text-sm dark:prose-invert max-w-none p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700 ">
                                            {!! Str::markdown($reply->message) !!}
                                        </div>

                                        <!-- Notes Section (Conditional) -->
                                        @if($reply->internal_notes)
                                        <div class="relative @if(!$isEven) pr-10 @else pl-10 @endif mb-6">
                                            <!-- Notes Indicator (Smaller line) -->
                                            <div class="absolute @if(!$isEven) right-0 @else left-0 @endif top-0 h-full w-0.5 bg-gray-200 dark:bg-gray-700 "></div>
                                            
                                            <!-- Notes Card -->
                                            <div class="border border-yellow-200 dark:border-yellow-800 bg-yellow-50/80 dark:bg-yellow-900/20 rounded-lg px-4 shadow-xs">
                                                <div class="flex items-start gap-3 ">
                                                    <!-- Notes Icon -->
                                                    <div class="flex-shrink-0 mt-0.5">
                                                        <div class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center text-yellow-600 dark:text-yellow-300">
                                                            <x-heroicon-o-document-text class="w-4 h-4" />
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Notes Content -->
                                                    <div class="flex-1 min-w-0 ">
                                                        <div class="flex items-center justify-between mb-1 @if(!$isEven) flex-row-reverse @endif">
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
                                        @php
                                            $attachments = json_decode($reply->attachment_path);
                                        @endphp

                                        @if (!empty($attachments))
                                            <div class="mt-1 text-right">
                                                @foreach ($attachments as $attachment)
                                                    <a href="{{ Storage::url($attachment) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center text-xs  text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 bg-primary-50/70 dark:bg-primary-900/30 px-3 rounded-lg border border-primary-100 dark:border-primary-800 hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                                                        
                                                        <x-heroicon-o-paper-clip class="w-4 h-4 mr-2" />

                                                        <span class="truncate max-w-xs">{{ basename($attachment) }}</span>

                                                        <x-heroicon-o-paper-clip class="w-4 h-4 ml-2" />
                                                        <x-heroicon-o-arrow-down-tray class="w-4 h-4 mr-2 ml-2 opacity-70" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
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
                <form wire:submit="submitReply">
                    <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-primary-200 dark:border-primary-800">
                        <div class="space-y-3">
                            <div class="space-y-1">

            <!-- Top Right Controls -->
            
                            
                                <!-- To Recipients -->
                                <div class="flex w-full items-center">
                                <div class="w-full flex items-center">
                                    <label style="padding-right:42px;" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">To</label>
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
    <!-- <div class="flex w-full items-center">
        <div class="w-full flex items-center">
            <label style="padding-right:38px;" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">CC</label>
            <input 
                type="email" 
                wire:model="replyData.cc_recipients"
                class="flex-1 font-small  border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="CC email"
                style="font-size:13px; padding:3px;">
        </div>
    </div> -->

    <!-- BCC Recipients - Conditionally shown -->
@if($showBcc)
    <div class="flex w-full items-center">
        <div class="w-full flex items-center">
            <label style="padding-right:29px;" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">BCC</label>
            <input 
                type="email" 
                wire:model="replyData.bcc"
                class="flex-1 font-small border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="BCC email"
                style="font-size:13px; padding:3px;">
        </div>
    </div>
@endif

    <!-- Subject -->
    <!-- <div class="flex w-full items-center">
        <div class="w-full flex items-center">
            <label  class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2 px-2">Subject</label>
            <input 
                type="text" 
                wire:model="replyData.subject" 
                required 
                maxlength="255"
                class="flex-1 font-small  border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="Subject"
                style="font-size:13px; padding:3px;">
        </div>
    </div> -->

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
    <!-- <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label> -->

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
    <!-- <div class="flex items-center">
        <input 
            type="checkbox" 
            wire:model="replyData.notify_customer" 
            id="notify_customer"
            class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:checked:bg-primary-500">
        <label 
            for="notify_customer" 
            class="ml-2 block text-sm text-gray-900 dark:text-white"
            style="font-size:13px;">Notify customer</label>
    </div> -->

                               
                            </div>
                            </div>
                        </div>
                <div class="flex justify-end mt-6 space-x-3">
            <div class="flex justify-end items-center space-x-2">
                                <!-- BCC Toggle Button -->
                                <!-- <button 
                                    type="button" 
                                    wire:click="$toggle('showBcc')"
                                    class="flex items-center text-xs px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded hover:bg-sky-100 dark:hover:bg-sky-900/50 transition-colors duration-200">
                                    {{ $showBcc ? 'Hide BCC' : 'Show BCC' }}
                                </button> -->
                                
                                
                            
                                <!-- Attachment Button -->
                                <div x-data="{ isUploading: false }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false">
                                    <label class="flex items-center cursor-pointer text-xs px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded hover:bg-sky-100 dark:hover:bg-sky-900/50 transition-colors duration-200">
                                        <x-heroicon-o-paper-clip class="w-4 h-4 mr-1" />
                                        Attach File
                                        <input 
                                            type="file" 
                                            wire:model="replyData.attachment_path" 
                                            class="hidden"
                                            multiple 
                                            accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    </label>
                                    
                                    <!-- Upload Progress Bar -->
                                    <div x-show="isUploading" class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-sky-500 h-1.5 rounded-full" style="width: 0%"
                                            x-on:livewire-upload-progress="document.querySelector('.bg-sky-500').style.width = `${event.detail.progress}%`">
                                        </div>
                                    </div>
                                </div>

                                <!-- File Preview Section -->
                                <div class="mt-2 text-right">
                                    <!-- Loading State -->
                                    <div wire:loading wire:target="replyData.attachment_path" class="text-xs text-gray-500 dark:text-gray-400">
                                        Uploading...
                                    </div>
                                    
                                    <!-- Uploaded File Preview -->
                                    <div wire:loading.remove wire:target="replyData.attachment_path">
                                        @if (is_array($replyData['attachment_path'] ?? null))
                                            @foreach ($replyData['attachment_path'] as $index => $file)
                                                @if (is_object($file) && method_exists($file, 'getClientOriginalName'))
                                                    <div class="flex items-center justify-end space-x-2 mt-1" wire:key="attachment-{{ $index }}">
                                                        @if (str_starts_with($file->getClientMimeType(), 'image/'))
                                                            <button type="button"
                                                                    x-on:click="$dispatch('img-preview', { src: '{{ $file->temporaryUrl() }}' })"
                                                                    class="text-sky-600 dark:text-sky-400 hover:underline text-xs flex items-center">
                                                                <x-heroicon-o-photo class="w-4 h-4 mr-1" />
                                                                {{ $file->getClientOriginalName() }}
                                                            </button>
                                                        @else
                                                            <a href="#"
                                                            wire:click.prevent="downloadTemporaryFile({{ $index }})"
                                                            class="text-sky-600 dark:text-sky-400 hover:underline text-xs flex items-center">
                                                                <x-heroicon-o-document-text class="w-4 h-4 mr-1" />
                                                                {{ $file->getClientOriginalName() }}
                                                            </a>
                                                        @endif
                                                        
                                                        <button type="button"
                                                                wire:click="removeAttachment({{ $index }})"
                                                                class="text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                                            <x-heroicon-o-x-mark class="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @elseif (is_string($replyData['attachment_path'] ?? null))
                                            <div class="flex items-center justify-end space-x-2">
                                                @php
                                                    $isImage = in_array(pathinfo($replyData['attachment_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                                                    $fullPath = Storage::url('ticket-attachments/' . $replyData['attachment_path']);
                                                @endphp
                                                
                                                @if ($isImage)
                                                    <button type="button"
                                                            x-on:click="$dispatch('img-preview', { src: '{{ $fullPath }}' })"
                                                            class="text-sky-600 dark:text-sky-400 hover:underline text-xs flex items-center">
                                                        <x-heroicon-o-photo class="w-4 h-4 mr-1" />
                                                        {{ $replyData['attachment_path'] }}
                                                    </button>
                                                @else
                                                    <a href="{{ $fullPath }}" 
                                                    target="_blank"
                                                    download="{{ $replyData['attachment_path'] }}"
                                                    class="text-sky-600 dark:text-sky-400 hover:underline text-xs flex items-center">
                                                        <x-heroicon-o-document-text class="w-4 h-4 mr-1" />
                                                        {{ $replyData['attachment_path'] }}
                                                    </a>
                                                @endif
                                                
                                                <button type="button"
                                                        wire:click="removeAttachment('{{ $replyData['attachment_path'] }}')"
                                                        class="text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                                    <x-heroicon-o-x-mark class="w-4 h-4" />
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Image Preview Modal -->
                                <div x-data="{ show: false, imgSrc: '' }" 
                                    x-on:img-preview.window="show = true; imgSrc = $event.detail.src"
                                    x-show="show"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
                                    <div class="relative max-w-5xl max-h-screen">
                                        <img :src="imgSrc" alt="Preview" class="max-w-full max-h-screen">
                                        <button x-on:click="show = false" 
                                                class="absolute top-4 right-4 text-white bg-red-500 hover:bg-red-600 rounded-full p-2">
                                            <x-heroicon-o-x-mark class="w-6 h-6" />
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Preview Modal -->
                            <div x-data="{ show: false, imgSrc: '' }" 
                                x-on:img-preview.window="show = true; imgSrc = $event.detail.src"
                                x-show="show"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
                                <div class="relative max-w-5xl max-h-screen">
                                    <img :src="imgSrc" alt="Preview" class="max-w-full max-h-screen">
                                    <button x-on:click="show = false" 
                                            class="absolute top-4 right-4 text-white bg-red-500 hover:bg-red-600 rounded-full p-2">
                                        <x-heroicon-o-x-mark class="w-6 h-6" />
                                    </button>
                                </div>
                            </div> 
                            <x-filament::button type="submit" size="lg" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700">
                                Send Reply
                            </x-filament::button>
                        </div>
                    </div>
                </form>
                
                
            </div>
         
            <!-- Right Panel - 30% width -->
            <div class="w-[35%] md:w-[30%] min-w-[30%]  bg-white space-y-1 p-3 rounded" style="width:32% !important">
                <!-- Ticket Card -->
                <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <!-- Ticket Header -->
                    <div class="flex items-start justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $this->record->title }}</h2>
                    </div>

                    <!-- Ticket Details - Horizontal Layout -->
                    <div class="">
                        <div class="grid grid-cols-1 md:grid-cols-5 text-sm">

                        <!-- Purpose -->
                            <div class="flex text-xs flex-col p-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
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
                                    <div class="relative tooltip_custom">
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
                                            class="absolute z-50 w-64 p-3 mt-2 text-md font-normal bg-red tooltip_custom_absolute text-black dark:bg-gray-600 rounded-md shadow-lg">
                                            @php
                                                // Convert to plain text with preserved line breaks
                                                $plainText = html_entity_decode(strip_tags($this->record->message));
                                                // Normalize whitespace and line breaks
                                                $plainText = preg_replace('/\s+/', ' ', $plainText);
                                                $plainText = str_replace(["\r\n", "\n", "\r"], "<br>", $plainText);
                                            @endphp
                                            {!! $plainText !!}
                                            
                                            <!-- Tooltip arrow -->
                                            <div class="absolute -top-1 left-4 w-10 h-2 bg-gray-800 dark:bg-gray-600 transform rotate-45"></div>
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
                
            <!-- Customer Info Card - Vertical Layout with Safe Icons -->
            <div class="bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-white px-4 py-2  flex items-center">
                    <x-heroicon-o-user-group class="w-6 h-6 mr-2 text-primary-500 dark:text-primary-400" />
                    Customer Information
                </h3>
                <div class="grid grid-cols-1 px-6">
                    <!-- Email -->
                    <div class="flex flex-col px-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                        <div class="flex items-center">
                            <x-heroicon-o-user-circle class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 px-2">Email: </span>
                            <span class="font-semibold text-gray-800 dark:text-white truncate">{{ $this->record->requested_email ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex flex-col px-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                        <div class="flex items-center">
                            <x-heroicon-o-ticket class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 px-2">Phone: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->createdBy->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <!-- Organization -->
                    <div class="flex flex-col px-1 bg-gray-50/80 dark:bg-gray-700/60 rounded-lg">
                        <div class="flex items-center">
                            <x-heroicon-o-calendar class="w-4 h-4 mr-2 text-primary-500 dark:text-primary-400 flex-shrink-0" />
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 px-2">Organization: </span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ $this->record->createdBy->company->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
<script>
window.onload = function () {
  const div = document.getElementById("myDiv");
  div.scrollTop = div.scrollHeight;
};

</script>
  
</x-filament::page>