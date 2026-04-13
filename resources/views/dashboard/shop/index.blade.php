{{-- resources/views/dashboard/shop/index.blade.php --}}
<x-layouts.dashboard title="Shop Dashboard">
    <x-slot:sidebar>
        <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('shop.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Overview
        </a>
        <a href="{{ route('shop.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('shop.bookings') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Bookings
        </a>
        <a href="{{ route('shop.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('shop.services') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Services
        </a>
        <a href="{{ route('shops.show', $shop->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            View Shop Page
        </a>
    </x-slot:sidebar>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
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
        <div class="glass-card p-5">
            <p class="text-gray-500 text-sm mb-1">Total Reviews</p>
            <p class="text-2xl font-display font-bold text-gray-900">{{ $totalReviews }} <span class="text-sm text-yellow-500">⭐ {{ number_format($shop->rating_avg, 1) }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Bookings --}}
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display font-semibold text-lg text-gray-900">Recent Bookings</h3>
                <a href="{{ route('shop.bookings') }}" class="text-primary-600 text-sm hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($shop->bookings->take(5) as $booking)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div>
                            <p class="text-gray-900 text-sm font-medium">{{ $booking->user->name ?? 'Customer' }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->booking_date->format('M d') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
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

        {{-- Recent Reviews --}}
        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Recent Reviews</h3>
            <div class="space-y-3">
                @forelse($shop->reviews->take(5) as $review)
                    <div class="p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-gray-900 text-sm font-medium">{{ $review->user->name }}</span>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">{{ Str::limit($review->comment, 100) }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No reviews yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>