<x-layouts.admin title="User Details">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">← Back to Users</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- User Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $user->avatar_url }}" class="w-20 h-20 rounded-full" alt="">
                        <div>
                            <h2 class="font-display font-semibold text-2xl text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-500">{{ $user->email }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="badge bg-gray-100 text-gray-700 capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
                                @if($user->is_suspended)
                                    <x-admin.status-badge status="suspended" />
                                @else
                                    <x-admin.status-badge status="active" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Phone</p>
                        <p class="text-gray-900 font-medium">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Joined</p>
                        <p class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Bookings</p>
                        <p class="text-gray-900 font-medium">{{ $user->bookings->count() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Reviews</p>
                        <p class="text-gray-900 font-medium">{{ $user->reviews->count() }}</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    @if($user->is_suspended)
                        <form method="POST" action="{{ route('admin.users.reactivate', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-primary">Reactivate Account</button>
                        </form>
                    @else
                        <button @click="$dispatch('open-modal-suspend')" class="btn-secondary">Suspend Account</button>
                    @endif
                    <button @click="$dispatch('open-modal-delete')" class="btn-secondary text-red-600">Delete Account</button>
                </div>
            </div>

            {{-- Booking History --}}
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Booking History</h3>
                <div class="space-y-3">
                    @forelse($user->bookings->take(10) as $booking)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                            <div>
                                <p class="text-gray-900 text-sm font-medium">{{ $booking->bookable->name ?? $booking->bookable->user->name ?? 'Provider' }}</p>
                                <p class="text-gray-500 text-xs">{{ $booking->booking_date->format('M d, Y') }} at {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-admin.status-badge :status="$booking->status" />
                                <span class="text-gray-900 text-sm">${{ number_format($booking->total_price, 0) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No bookings yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Review History --}}
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Review History</h3>
                <div class="space-y-3">
                    @forelse($user->reviews->take(10) as $review)
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-gray-900 text-sm font-medium">{{ $review->reviewable->name ?? $review->reviewable->user->name ?? 'Provider' }}</span>
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No reviews yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            @if($user->shop)
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Shop</h3>
                <a href="{{ route('admin.shops.show', $user->shop) }}" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <p class="text-gray-900 font-medium">{{ $user->shop->name }}</p>
                    <p class="text-gray-500 text-xs">{{ $user->shop->city }}</p>
                    <x-admin.status-badge :status="$user->shop->approval_status" class="mt-2" />
                </a>
            </div>
            @endif

            @if($user->freelancerProfile)
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Freelancer Profile</h3>
                <a href="{{ route('admin.freelancers.show', $user->freelancerProfile) }}" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                    <p class="text-gray-500 text-xs">{{ $user->freelancerProfile->city }}</p>
                    <x-admin.status-badge :status="$user->freelancerProfile->approval_status" class="mt-2" />
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Suspend Modal --}}
    <x-admin.modal id="suspend" title="Suspend User">
        <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
            @csrf @method('PATCH')
            <p class="text-gray-600 mb-4">Are you sure you want to suspend {{ $user->name }}? They will not be able to access their account.</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-suspend')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Suspend</button>
            </div>
        </form>
    </x-admin.modal>

    {{-- Delete Modal --}}
    <x-admin.modal id="delete" title="Delete User">
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
            @csrf @method('DELETE')
            <p class="text-gray-600 mb-4">Are you sure you want to delete {{ $user->name }}? This action cannot be undone.</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-delete')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Delete</button>
            </div>
        </form>
    </x-admin.modal>
</x-layouts.admin>
