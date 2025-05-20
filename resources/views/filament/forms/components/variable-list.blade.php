@php
    $variables = \App\Models\FieldVariables::all();
@endphp

<div x-data="{ showCopied: false }" class="w-full relative">
    <label class="block font-medium text-sm text-black-900 mb-2">Click to copy a variable:</label>

    <div class="flex flex-wrap gap-2">
        @foreach($variables as $variable)
            <button
                type="button"
                @click="navigator.clipboard.writeText('{{ '{' . $variable->name . '}' }}'); window.dispatchEvent(new CustomEvent('copied'))"
                class="cursor-pointer px-2 py-1 bg-gray-200 rounded text-sm hover:bg-gray-300 focus:outline-none focus:ring focus:ring-indigo-200"
                title="Click to copy"
            >
                {{ '{' . $variable->name . '}' }}
            </button>
        @endforeach
    </div>

    <!-- Toast Notification -->
    <div
        x-on:copied.window="showCopied = true; setTimeout(() => showCopied = false, 2000)"
        x-show="showCopied"
        x-transition
        class="fixed top-4 right-4 z-50 bg-green-100 text-green-800 border border-green-300 px-4 py-2 rounded shadow-lg text-sm"
        style="display: none;"
    >
        ✅ Variable copied to clipboard!
    </div>
</div>
