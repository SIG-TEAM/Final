@props(['active'])

@php
$classes = ($active ?? false)
    ? 'text-gray-900 bg-green-50 px-3 py-1 rounded-full text-sm font-medium'
    : 'text-gray-600 hover:text-gray-900 hover:bg-green-50 px-3 py-1 rounded-full text-sm font-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
