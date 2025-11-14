@props([
    'href' => '#',
    'icon' => null,
    'badge' => null,
    'badgeColor' => 'gray',
    'active' => false,
])

@php
    $baseClasses =
        'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500';
    $stateClasses = $active ? 'text-indigo-600 bg-indigo-50 font-semibold' : 'text-gray-700 hover:bg-gray-50';
    $layoutClasses = $badge ? 'justify-between' : '';
    $classes = trim("{$baseClasses} {$stateClasses} {$layoutClasses}");

    $iconClasses = $active ? 'text-indigo-600' : 'text-gray-500';

    $badgePalette = [
        'indigo' => 'bg-indigo-100 text-indigo-700',
        'gray' => 'bg-gray-100 text-gray-600',
        'green' => 'bg-green-100 text-green-700',
    ];
    $badgeClasses = $badgePalette[$badgeColor] ?? $badgePalette['gray'];
@endphp

<a
    {{ $attributes->merge([
        'href' => $href,
        'class' => $classes,
        'aria-current' => $active ? 'page' : null,
    ]) }}>
    <div class="flex items-center gap-3">
        @isset($prefix)
            {{ $prefix }}
        @elseif ($icon)
            <i class="{{ $icon }} w-5 text-center {{ $iconClasses }}"></i>
            @endif
            <span class="font-medium truncate">{{ $slot }}</span>
        </div>
        @if ($badge)
            <span class="ml-3 px-2 py-0.5 text-xs font-medium rounded {{ $badgeClasses }}">{{ $badge }}</span>
        @endif
    </a>
