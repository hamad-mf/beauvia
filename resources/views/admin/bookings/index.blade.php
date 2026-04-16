<x-layouts.admin title="Booking Management">
    {{-- Status Filter Tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto">
        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('status') ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'pending' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Pending ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'confirmed' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Confirmed ({{ $statusCounts['confirmed'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'completed' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Completed ({{ $statusCounts['completed'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'cancelled' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Cancelled ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    {{-- Search/Filter Bar --}}
    <x-admin.filter-bar searchPlaceholder="Search by booking ID, customer, or provider...">
        <select name="provider_type" class="input-dark">
            <option value="">All Providers</option>
            <option value="shop" {{ request('provider_type') === 'shop' ? 'selected' : '' }}>Shops</option>
            <option value="freelancer" {{ request('provider_type') === 'freelancer' ? 'selected' : '' }}>Freelancers</option>
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-dark" placeholder="From Date">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-dark" placeholder="To Date">
    </x-admin.filter-bar>

    {{-- Export Button --}}
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.bookings.export', request()->all()) }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
    </div>

    {{-- Data Table --}}
    <x-admin.data-table :headers="['ID', 'Customer', 'Provider', 'Date', 'Time', 'Services', 'Total', 'Status', 'Actions']">
        @forelse($bookings as $booking)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-sm text-gray-600">#{{ $booking->id }}</td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <img src="{{ $booking->user->avatar_url }}" class="w-8 h-8 rounded-full" alt="">
                    <div>
                        <p class="text-gray-900 font-medium text-sm">{{ $booking->user->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $booking->user->email }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3">
                <p class="text-gray-900 font-medium text-sm">{{ $booking->bookable->name ?? $booking->bookable->user->name ?? 'Provider' }}</p>
                <p class="text-gray-500 text-xs">{{ $booking->bookable_type === 'App\\Models\\Shop' ? 'Shop' : 'Freelancer' }}</p>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $booking->booking_date->format('M d, Y') }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $booking->services->count() }}</td>
            <td class="px-4 py-3 text-sm text-gray-900 font-semibold">${{ number_format($booking->total_price, 0) }}</td>
            <td class="px-4 py-3">
                <x-admin.status-badge :status="$booking->status" />
            </td>
            <td class="px-4 py-3">
                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-primary-600 hover:text-primary-700 text-sm">View</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="px-4 py-8 text-center text-gray-500">No bookings found</td>
        </tr>
        @endforelse
    </x-admin.data-table>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</x-layouts.admin>
