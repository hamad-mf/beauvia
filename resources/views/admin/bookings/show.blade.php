<x-layouts.admin title="Booking Details">
    <div class="mb-6">
        <a href="{{ route('admin.bookings.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">← Back to Bookings</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Booking Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="font-display font-semibold text-2xl text-gray-900 mb-2">Booking #{{ $booking->id }}</h2>
                        <x-admin.status-badge :status="$booking->status" />
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm">Total Amount</p>
                        <p class="text-2xl font-display font-bold gradient-text">${{ number_format($booking->total_price, 0) }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Booking Date</p>
                        <p class="text-gray-900 font-medium">{{ $booking->booking_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Time</p>
                        <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Created</p>
                        <p class="text-gray-900 font-medium">{{ $booking->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Last Updated</p>
                        <p class="text-gray-900 font-medium">{{ $booking->updated_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>

                @if($booking->status === 'cancelled' && $booking->cancellation_reason)
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 mb-6">
                    <p class="text-red-700 text-sm font-medium mb-1">Cancellation Reason:</p>
                    <p class="text-red-600 text-sm">{{ $booking->cancellation_reason }}</p>
                </div>
                @endif

                @if($booking->notes)
                <div class="p-4 rounded-xl bg-gray-50 mb-6">
                    <p class="text-gray-700 text-sm font-medium mb-1">Customer Notes:</p>
                    <p class="text-gray-600 text-sm">{{ $booking->notes }}</p>
                </div>
                @endif

                @if($booking->status !== 'cancelled')
                <div class="flex gap-3">
                    <button @click="$dispatch('open-modal-cancel')" class="btn-secondary text-red-600">Cancel Booking</button>
                </div>
                @endif
            </div>

            {{-- Services --}}
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Services</h3>
                <div class="space-y-3">
                    @foreach($booking->services as $service)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                            <div>
                                <p class="text-gray-900 font-medium">{{ $service->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $service->duration }} min</p>
                            </div>
                            <span class="text-gray-900 font-semibold">${{ number_format($service->price, 0) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($booking->staffMember)
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Staff Member</h3>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                    <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 font-display font-bold">
                        {{ substr($booking->staffMember->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-medium">{{ $booking->staffMember->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $booking->staffMember->role }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Customer</h3>
                <a href="{{ route('admin.users.show', $booking->user) }}" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ $booking->user->avatar_url }}" class="w-12 h-12 rounded-full" alt="">
                        <div>
                            <p class="text-gray-900 font-medium">{{ $booking->user->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->user->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $booking->user->phone ?? 'No phone' }}
                        </div>
                    </div>
                </a>
            </div>

            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Provider</h3>
                <a href="{{ $booking->bookable_type === 'App\\Models\\Shop' ? route('admin.shops.show', $booking->bookable) : route('admin.freelancers.show', $booking->bookable) }}" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3 mb-3">
                        @if($booking->bookable_type === 'App\\Models\\Shop')
                            <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-display font-bold">
                                {{ substr($booking->bookable->name, 0, 1) }}
                            </div>
                        @else
                            <img src="{{ $booking->bookable->user->avatar_url }}" class="w-12 h-12 rounded-full" alt="">
                        @endif
                        <div>
                            <p class="text-gray-900 font-medium">{{ $booking->bookable->name ?? $booking->bookable->user->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->bookable_type === 'App\\Models\\Shop' ? 'Shop' : 'Freelancer' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $booking->bookable->city }}
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $booking->bookable->phone }}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Cancel Modal --}}
    <x-admin.modal id="cancel" title="Cancel Booking">
        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Cancellation Reason</label>
                <textarea name="cancellation_reason" rows="4" class="input-dark" required placeholder="Explain why this booking is being cancelled..."></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-cancel')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Cancel Booking</button>
            </div>
        </form>
    </x-admin.modal>
</x-layouts.admin>
