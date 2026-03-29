<x-layouts.dashboard title="Shop Bookings">
    <x-slot:sidebar>
        <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5 transition-colors">📊 Overview</a>
        <a href="{{ route('shop.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-600/20 text-primary-300">📅 Bookings</a>
        <a href="{{ route('shop.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5">📦 Services</a>
    </x-slot:sidebar>

    <div class="glass-card p-6">
        <h3 class="font-display font-semibold text-lg text-white mb-4">All Bookings</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-dark-400 border-b border-white/10">
                    <th class="py-3 px-2">Customer</th><th class="py-3 px-2">Date & Time</th><th class="py-3 px-2">Services</th><th class="py-3 px-2">Total</th><th class="py-3 px-2">Status</th><th class="py-3 px-2">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-white/5 hover:bg-white/5">
                        <td class="py-3 px-2 text-white">{{ $booking->user->name }}</td>
                        <td class="py-3 px-2 text-dark-300">{{ $booking->booking_date->format('M d') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</td>
                        <td class="py-3 px-2 text-dark-300">{{ $booking->services->pluck('name')->join(', ') }}</td>
                        <td class="py-3 px-2 text-white font-semibold">${{ number_format($booking->total_price, 0) }}</td>
                        <td class="py-3 px-2"><span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                        <td class="py-3 px-2">
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('shop.bookings.status', $booking) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button class="text-emerald-400 hover:underline text-xs mr-2">Confirm</button>
                                </form>
                                <form method="POST" action="{{ route('shop.bookings.status', $booking) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="text-red-400 hover:underline text-xs">Decline</button>
                                </form>
                            @elseif($booking->status === 'confirmed')
                                <form method="POST" action="{{ route('shop.bookings.status', $booking) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button class="text-emerald-400 hover:underline text-xs">Complete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-8 text-center text-dark-400">No bookings</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-layouts.dashboard>
