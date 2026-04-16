<x-layouts.admin title="Shop Details">
    <div class="mb-6">
        <a href="{{ route('admin.shops.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">← Back to Shops</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Shop Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="font-display font-semibold text-2xl text-gray-900 mb-2">{{ $shop->name }}</h2>
                        <p class="text-gray-500 mb-3">{{ $shop->description }}</p>
                        <div class="flex items-center gap-2">
                            <x-admin.status-badge :status="$shop->approval_status" />
                            @if($shop->is_active)
                                <span class="badge bg-emerald-100 text-emerald-700">Active</span>
                            @else
                                <span class="badge bg-gray-100 text-gray-700">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Owner</p>
                        <p class="text-gray-900 font-medium">{{ $shop->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Category</p>
                        <p class="text-gray-900 font-medium">{{ $shop->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Location</p>
                        <p class="text-gray-900 font-medium">{{ $shop->address }}, {{ $shop->city }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Phone</p>
                        <p class="text-gray-900 font-medium">{{ $shop->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Rating</p>
                        <p class="text-gray-900 font-medium">⭐ {{ number_format($shop->rating_avg, 1) }} ({{ $shop->rating_count }} reviews)</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Created</p>
                        <p class="text-gray-900 font-medium">{{ $shop->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                @if($shop->approval_status === 'rejected' && $shop->rejection_reason)
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 mb-6">
                    <p class="text-red-700 text-sm font-medium mb-1">Rejection Reason:</p>
                    <p class="text-red-600 text-sm">{{ $shop->rejection_reason }}</p>
                </div>
                @endif

                <div class="flex gap-3">
                    @if($shop->approval_status === 'pending')
                        <form method="POST" action="{{ route('admin.shops.approve', $shop) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-primary">Approve Shop</button>
                        </form>
                        <button @click="$dispatch('open-modal-reject')" class="btn-secondary">Reject Shop</button>
                    @endif
                    
                    @if($shop->is_active)
                        <form method="POST" action="{{ route('admin.shops.suspend', $shop) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-secondary text-red-600">Suspend Shop</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.shops.reactivate', $shop) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-primary">Reactivate Shop</button>
                        </form>
                    @endif
                    
                    <a href="{{ route('shops.show', $shop->slug) }}" target="_blank" class="btn-secondary">View Public Page</a>
                </div>
            </div>

            {{-- Services --}}
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Services ({{ $shop->services->count() }})</h3>
                <div class="space-y-3">
                    @forelse($shop->services as $service)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                            <div>
                                <p class="text-gray-900 font-medium">{{ $service->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $service->duration }} min</p>
                            </div>
                            <span class="text-gray-900 font-semibold">${{ number_format($service->price, 0) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No services yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Bookings --}}
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Recent Bookings</h3>
                <div class="space-y-3">
                    @forelse($shop->bookings->take(10) as $booking)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                            <div>
                                <p class="text-gray-900 text-sm font-medium">{{ $booking->user->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $booking->booking_date->format('M d, Y') }}</p>
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

            {{-- Reviews --}}
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Reviews ({{ $shop->reviews->count() }})</h3>
                <div class="space-y-3">
                    @forelse($shop->reviews as $review)
                        <div class="p-3 rounded-xl bg-gray-50">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-gray-900 text-sm font-medium">{{ $review->user->name }}</span>
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                @if($review->is_flagged)
                                    <span class="badge bg-red-100 text-red-700 text-xs">Flagged</span>
                                @endif
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
            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 text-sm">Total Services</span>
                        <span class="text-gray-900 font-semibold">{{ $shop->services->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 text-sm">Total Bookings</span>
                        <span class="text-gray-900 font-semibold">{{ $shop->bookings->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 text-sm">Total Reviews</span>
                        <span class="text-gray-900 font-semibold">{{ $shop->reviews->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 text-sm">Gallery Images</span>
                        <span class="text-gray-900 font-semibold">{{ $shop->galleries->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Owner Details</h3>
                <a href="{{ route('admin.users.show', $shop->user) }}" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <img src="{{ $shop->user->avatar_url }}" class="w-10 h-10 rounded-full" alt="">
                        <div>
                            <p class="text-gray-900 font-medium">{{ $shop->user->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $shop->user->email }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <x-admin.modal id="reject" title="Reject Shop">
        <form method="POST" action="{{ route('admin.shops.reject', $shop) }}">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Rejection Reason</label>
                <textarea name="rejection_reason" rows="4" class="input-dark" required placeholder="Explain why this shop is being rejected..."></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-reject')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Reject Shop</button>
            </div>
        </form>
    </x-admin.modal>
</x-layouts.admin>
