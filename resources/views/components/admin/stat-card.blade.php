{{-- resources/views/components/admin/stat-card.blade.php --}}
@props(['title', 'value', 'icon' => null, 'color' => 'gray'])

@php
$colorClasses = [
    'gray' => 'text-gray-900',
    'primary' => 'gradient-text',
    'emerald' => 'text-emerald-600',
    'yellow' => 'text-yellow-600',
    'red' => 'text-red-600',
    'blue' => 'text-blue-600',
];
$textColor = $colorClasses[$color] ?? $colorClasses['gray'];
@endphp

<div class="glass-card p-5">
    @if($icon)
    <div class="flex items-center justify-between mb-2">
        <p class="text-gray-500 text-sm">{{ $title }}</p>
        <div class="text-{{ $color }}-500">
            {!! $icon !!}
        </div>
    </div>
    @else
    <p class="text-gray-500 text-sm mb-1">{{ $title }}</p>
    @endif
    <p class="text-2xl font-display font-bold {{ $textColor }}">{{ $value }}</p>
</div>
