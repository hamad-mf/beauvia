{{-- resources/views/components/admin/status-badge.blade.php --}}
@props(['status'])

@php
$statusColors = [
    'pending' => 'bg-yellow-100 text-yellow-700',
    'approved' => 'bg-emerald-100 text-emerald-700',
    'rejected' => 'bg-red-100 text-red-700',
    'confirmed' => 'bg-blue-100 text-blue-700',
    'completed' => 'bg-emerald-100 text-emerald-700',
    'cancelled' => 'bg-gray-100 text-gray-700',
    'active' => 'bg-emerald-100 text-emerald-700',
    'suspended' => 'bg-red-100 text-red-700',
    'inactive' => 'bg-gray-100 text-gray-700',
];
$colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
@endphp

<span class="badge {{ $colorClass }}">{{ ucfirst($status) }}</span>
