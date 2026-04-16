{{-- resources/views/components/admin/filter-bar.blade.php --}}
@props(['searchPlaceholder' => 'Search...'])

<div class="glass-card p-4 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="input-dark">
        </div>
        {{ $slot }}
        <button type="submit" class="btn-primary whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Search
        </button>
    </form>
</div>
