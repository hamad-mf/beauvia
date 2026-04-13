<x-layouts.dashboard title="My Dashboard">
    <x-slot:sidebar>
        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('customer.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Overview
        </a>
        <a href="{{ route('customer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('customer.bookings') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            My Bookings
        </a>
        <a href="{{ route('shops.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Browse Shops
        </a>
    </x-slot:sidebar>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">Upcoming</p>
            <p class="text-2xl font-display font-bold text-gray-900">{{ $upcomingCount }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">Completed</p>
            <p class="text-2xl font-display font-bold text-emerald-600">{{ $completedCount }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">Total Spent</p>
            <p class="text-2xl font-display font-bold gradient-text">${{ number_format($totalSpent, 0) }}</p>
        </div>
    </div>

    {{-- Bookings --}}
    <div class="glass-card p-6">
        <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Recent Bookings</h3>
        <div class="space-y-3">
            @forelse($bookings as $booking)
                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-display font-bold">
                            {{ $booking->booking_date->format('d') }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $booking->provider_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $booking->booking_date->format('M d, Y') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                        <span class="text-gray-900 font-semibold">${{ number_format($booking->total_price, 0) }}</span>
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel this booking?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-red-600 hover:text-red-700 text-xs">Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">No bookings yet</p>
                    <a href="{{ route('shops.index') }}" class="btn-primary text-sm">Book Your First Appointment</a>
                </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-layouts.dashboard>
