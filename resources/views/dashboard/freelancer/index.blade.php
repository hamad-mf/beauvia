<x-layouts.dashboard title="Freelancer Dashboard">
    <x-slot:sidebar>
        <a href="{{ route('freelancer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('freelancer.dashboard') ? 'bg-primary-600/20 text-primary-300' : 'text-dark-300 hover:text-white hover:bg-white/5' }} transition-colors">📊 Overview</a>
        <a href="{{ route('freelancer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('freelancer.bookings') ? 'bg-primary-600/20 text-primary-300' : 'text-dark-300 hover:text-white hover:bg-white/5' }} transition-colors">📅 Bookings</a>
        <a href="{{ route('freelancer.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('freelancer.services') ? 'bg-primary-600/20 text-primary-300' : 'text-dark-300 hover:text-white hover:bg-white/5' }} transition-colors">📦 Services</a>
        <a href="{{ route('freelancers.show', $profile->id) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5 transition-colors">👁 View Profile</a>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-5">
            <p class="text-dark-400 text-sm mb-1">Today's Bookings</p>
            <p class="text-2xl font-display font-bold text-white">{{ $todayBookings }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-dark-400 text-sm mb-1">Pending</p>
            <p class="text-2xl font-display font-bold text-yellow-400">{{ $pendingBookings }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-dark-400 text-sm mb-1">This Month Revenue</p>
            <p class="text-2xl font-display font-bold gradient-text">${{ number_format($monthRevenue, 0) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display font-semibold text-lg text-white">Recent Bookings</h3>
                <a href="{{ route('freelancer.bookings') }}" class="text-primary-400 text-sm hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($profile->bookings->take(5) as $booking)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-white/5">
                        <div>
                            <p class="text-white text-sm font-medium">{{ $booking->user->name ?? 'Customer' }}</p>
                            <p class="text-dark-400 text-xs">{{ $booking->booking_date->format('M d, Y') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
                            @if($booking->customer_address)
                                <p class="text-blue-400 text-xs">🏠 {{ Str::limit($booking->customer_address, 30) }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge {{ $booking->status_badge }} text-xs">{{ ucfirst($booking->status) }}</span>
                            <span class="text-white text-sm">${{ number_format($booking->total_price, 0) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-dark-400 text-center py-4">No bookings yet</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-white mb-4">Recent Reviews</h3>
            <div class="space-y-3">
                @forelse($profile->reviews->take(5) as $review)
                    <div class="p-3 rounded-xl bg-white/5">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-white text-sm">{{ $review->user->name }}</span>
                            <div class="flex gap-0.5">@for($i=1;$i<=5;$i++)<svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-dark-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                        </div>
                        <p class="text-dark-300 text-sm">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-dark-400 text-center py-4">No reviews yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>
