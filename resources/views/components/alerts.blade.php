@props([
    'variant' => 'success', 'error', 'warning',
    'title' => '',
    'message' => '',
    'showLink' => false,
    'linkHref' => '#',
    'linkText' => ''
])

@php
    $colors = [
        'success' => 'bg-green-100 text-green-800 border-green-300',
        'error' => 'bg-red-100 text-red-800 border-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
    ];
@endphp

<div class="p-4 mb-4 border rounded-lg {{ $colors[$variant] ?? $colors['success'] }}">
    <strong class="block font-semibold">{{ $title }}</strong>
    <span>{{ $message }}</span>

    @if($showLink)
        <div class="mt-2">
            <a href="{{ $linkHref }}" class="underline font-medium">
                {{ $linkText }}
            </a>
        </div>
    @endif
</div>