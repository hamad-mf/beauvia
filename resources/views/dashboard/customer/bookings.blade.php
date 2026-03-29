<x-layouts.dashboard title="My Bookings">
    <x-slot:sidebar>
        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Overview
        </a>
        <a href="{{ route('customer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-600/20 text-primary-300 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            My Bookings
        </a>
    </x-slot:sidebar>

    <div class="glass-card p-6">
        <h3 class="font-display font-semibold text-lg text-white mb-4">All Bookings</h3>
        <div class="space-y-3">
            @forelse($bookings as $booking)
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-600/20 flex items-center justify-center text-primary-400 font-display font-bold text-sm">
                            {{ $booking->booking_date->format('M') }}<br>{{ $booking->booking_date->format('d') }}
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $booking->provider_name }}</p>
                            <p class="text-dark-400 text-sm">{{ $booking->booking_date->format('l, M d, Y') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
                            <p class="text-dark-500 text-xs">Code: {{ $booking->booking_code }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                        <span class="text-white font-semibold">${{ number_format($booking->total_price, 0) }}</span>
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel?')">
                                @csrf @method('PATCH')
                                <button class="text-red-400 hover:text-red-300 text-xs">Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-dark-400 text-center py-8">No bookings found</p>
            @endforelse
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-layouts.dashboard>
