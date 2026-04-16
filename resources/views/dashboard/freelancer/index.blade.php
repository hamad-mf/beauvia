{{-- resources/views/dashboard/freelancer/index.blade.php --}}
<x-layouts.dashboard title="Freelancer Dashboard">
    <x-slot:sidebar>
        <a href="{{ route('freelancer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('freelancer.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
            Overview
        </a>
        <a href="{{ route('freelancer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('freelancer.bookings') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            Bookings
        </a>
        <a href="{{ route('freelancer.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('freelancer.services') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/></svg>
            Services
        </a>
        <a href="{{ route('freelancers.show', $profile->id) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
            View Profile
        </a>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">Today's Bookings</p>
            <p class="text-2xl font-display font-bold text-gray-900">{{ $todayBookings }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">Pending</p>
            <p class="text-2xl font-display font-bold text-yellow-600">{{ $pendingBookings }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">This Month Revenue</p>
            <p class="text-2xl font-display font-bold gradient-text">${{ number_format($monthRevenue, 0) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display font-semibold text-lg text-gray-900">Recent Bookings</h3>
                <a href="{{ route('freelancer.bookings') }}" class="text-primary-600 text-sm hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($profile->bookings->take(5) as $booking)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div>
                            <p class="text-gray-900 text-sm font-medium">{{ $booking->user->name ?? 'Customer' }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->booking_date->format('M d, Y') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
                            @if($booking->customer_address)
                                <p class="text-blue-500 text-xs">🏠 {{ Str::limit($booking->customer_address, 30) }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge {{ $booking->status_badge }} text-xs">{{ ucfirst($booking->status) }}</span>
                            <span class="text-gray-900 text-sm">${{ number_format($booking->total_price, 0) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No bookings yet</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Recent Reviews</h3>
            <div class="space-y-3">
                @forelse($profile->reviews->take(5) as $review)
                    <div class="p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-gray-900 text-sm">{{ $review->user->name }}</span>
                            <div class="flex gap-0.5">@for($i=1;$i<=5;$i++)<svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                        </div>
                        <p class="text-gray-600 text-sm">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No reviews yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>