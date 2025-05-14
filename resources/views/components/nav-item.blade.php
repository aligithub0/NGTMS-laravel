@props(['active' => false, 'href'])

@php
$classes = $active
    ? 'bg-primary-50 border-primary-500 text-primary-700 border-l-4 flex items-center px-3 py-2 text-sm font-medium'
    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center px-3 py-2 text-sm font-medium';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <span class="flex-shrink-0 h-5 w-5 text-gray-400">
        {{ $icon ?? '' }}
    </span>
    <span class="ml-3">
        {{ $slot }}
    </span>
</a>