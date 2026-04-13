{{-- resources/views/dashboard/freelancer/bookings.blade.php --}}
<x-layouts.dashboard title="My Bookings">
    <x-slot:sidebar>
        <a href="{{ route('freelancer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">📊 Overview</a>
        <a href="{{ route('freelancer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-50 text-primary-700">📅 Bookings</a>
        <a href="{{ route('freelancer.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">📦 Services</a>
    </x-slot:sidebar>

    <div class="glass-card p-6">
        <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">All Bookings</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b border-gray-200">
                    <th class="py-3 px-2">Customer</th><th class="py-3 px-2">Date & Time</th><th class="py-3 px-2">Location</th><th class="py-3 px-2">Total</th><th class="py-3 px-2">Status</th><th class="py-3 px-2">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-2 text-gray-900">{{ $booking->user->name }}</td>
                        <td class="py-3 px-2 text-gray-600">{{ $booking->booking_date->format('M d') }} {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</td>
                        <td class="py-3 px-2 text-gray-600">{{ $booking->customer_address ? '🏠 ' . Str::limit($booking->customer_address, 25) : 'N/A' }}</td>
                        <td class="py-3 px-2 text-gray-900 font-semibold">${{ number_format($booking->total_price, 0) }}</td>
                        <td class="py-3 px-2"><span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                        <td class="py-3 px-2">
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('freelancer.bookings.status', $booking) }}" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="confirmed"><button class="text-emerald-600 hover:underline text-xs mr-2">Accept</button></form>
                                <form method="POST" action="{{ route('freelancer.bookings.status', $booking) }}" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="text-red-500 hover:underline text-xs">Decline</button></form>
                            @elseif($booking->status === 'confirmed')
                                <form method="POST" action="{{ route('freelancer.bookings.status', $booking) }}" class="inline">@csrf @method('PATCH')<input type="hidden" name="status" value="completed"><button class="text-emerald-600 hover:underline text-xs">Complete</button></form>
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