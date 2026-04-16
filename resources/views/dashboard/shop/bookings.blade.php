{{-- resources/views/dashboard/shop/bookings.blade.php --}}
<x-layouts.dashboard title="Shop Bookings">
    <x-slot:sidebar>
        <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
            Overview
        </a>
        <a href="{{ route('shop.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-50 text-primary-700 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            Bookings
        </a>
        <a href="{{ route('shop.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/></svg>
            Services
        </a>
        <a href="{{ route('shops.show', $shop->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
            View Shop Page
        </a>
    </x-slot:sidebar>

    <div class="glass-card p-6">
        <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">All Bookings</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b border-gray-200">
                    <th class="py-3 px-2">Customer</th><th class="py-3 px-2">Date & Time</th><th class="py-3 px-2">Services</th><th class="py-3 px-2">Total</th><th class="py-3 px-2">Status</th><th class="py-3 px-2">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-2 text-gray-900">{{ $booking->user->name }}</td>
                        <td class="py-3 px-2 text-gray-600">{{ $booking->booking_date->format('M d') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</td>
                        <td class="py-3 px-2 text-gray-600">{{ $booking->services->pluck('name')->join(', ') }}</td>
                        <td class="py-3 px-2 text-gray-900 font-semibold">${{ number_format($booking->total_price, 0) }}</td>
                        <td class="py-3 px-2"><span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                        <td class="py-3 px-2">
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('shop.bookings.status', $booking) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button class="text-emerald-600 hover:underline text-xs mr-2">Confirm</button>
                                </form>
                                <form method="POST" action="{{ route('shop.bookings.status', $booking) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="text-red-500 hover:underline text-xs">Decline</button>
                                </form>
                            @elseif($booking->status === 'confirmed')
                                <form method="POST" action="{{ route('shop.bookings.status', $booking) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button class="text-emerald-600 hover:underline text-xs">Complete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-8 text-center text-gray-500">No bookings</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
</x-layouts.dashboard>