{{-- resources/views/dashboard/customer/bookings.blade.php --}}
<x-layouts.dashboard title="My Bookings">
    <x-slot:sidebar>
        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
            Overview
        </a>
        <a href="{{ route('customer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-50 text-primary-700 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            My Bookings
        </a>
        <a href="{{ route('shops.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/></svg>
            Browse Shops
        </a>
    </x-slot:sidebar>

    <div class="glass-card p-6">
        <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">All Bookings</h3>
        <div class="space-y-3">
            @forelse($bookings as $booking)
                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-display font-bold text-sm">
                            {{ $booking->booking_date->format('M') }}<br>{{ $booking->booking_date->format('d') }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $booking->provider_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $booking->booking_date->format('l, M d, Y') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
                            <p class="text-gray-400 text-xs">Code: {{ $booking->booking_code }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                        <span class="text-gray-900 font-semibold">${{ number_format($booking->total_price, 0) }}</span>
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel?')">
                                @csrf @method('PATCH')
                                <button class="text-red-500 hover:text-red-700 text-xs">Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No bookings found</p>
            @endforelse
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-layouts.dashboard>