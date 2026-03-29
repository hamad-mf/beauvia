<x-layouts.app :title="$shop->name">
    {{-- Cover --}}
    <section class="relative h-72 md:h-96 bg-gradient-to-br from-primary-950 via-dark-900 to-dark-950 overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center text-[12rem] opacity-10">{{ $shop->category->icon ?? '✨' }}</div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark-950 via-transparent to-transparent"></div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10 pb-20">
        {{-- Header --}}
        <div class="glass-card p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="badge bg-primary-500/20 text-primary-300 border border-primary-500/30">{{ $shop->category->name }}</span>
                        @if($shop->is_featured)<span class="badge bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">⭐ Featured</span>@endif
                    </div>
                    <h1 class="font-display text-3xl md:text-4xl font-bold text-white mb-2">{{ $shop->name }}</h1>
                    <div class="flex items-center gap-4 text-sm text-dark-400">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-white font-semibold">{{ number_format($shop->rating_avg, 1) }}</span>
                            <span>({{ $shop->rating_count }} reviews)</span>
                        </div>
                        <span class="text-dark-600">•</span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $shop->address }}
                        </div>
                    </div>
                </div>
                <a href="{{ route('bookings.create.shop', $shop->slug) }}" class="btn-primary !px-8 !py-4 text-lg shrink-0">Book Now</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- About --}}
                <div class="glass-card p-6">
                    <h2 class="font-display font-semibold text-xl text-white mb-4">About</h2>
                    <p class="text-dark-300 leading-relaxed">{{ $shop->description }}</p>
                </div>

                {{-- Services --}}
                <div class="glass-card p-6">
                    <h2 class="font-display font-semibold text-xl text-white mb-6">Services</h2>
                    <div class="space-y-4">
                        @foreach($shop->services as $service)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                <div class="flex-grow">
                                    <h3 class="text-white font-medium">{{ $service->name }}</h3>
                                    <p class="text-dark-400 text-sm mt-1">{{ $service->description }}</p>
                                    <span class="text-dark-500 text-xs mt-1 inline-block">⏱ {{ $service->formatted_duration }}</span>
                                </div>
                                <div class="text-right shrink-0 ml-4">
                                    <span class="text-white font-semibold text-lg">${{ number_format($service->price, 0) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Team --}}
                @if($shop->staffMembers->count())
                <div class="glass-card p-6">
                    <h2 class="font-display font-semibold text-xl text-white mb-6">Our Team</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($shop->staffMembers as $staff)
                            <div class="text-center p-4 rounded-xl bg-white/5">
                                <img src="{{ $staff->avatar_url }}" class="w-16 h-16 rounded-full mx-auto mb-3 border-2 border-primary-500/30" alt="{{ $staff->name }}">
                                <h4 class="text-white font-medium text-sm">{{ $staff->name }}</h4>
                                <p class="text-dark-400 text-xs">{{ $staff->title }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Reviews --}}
                <div class="glass-card p-6">
                    <h2 class="font-display font-semibold text-xl text-white mb-6">Reviews ({{ $shop->rating_count }})</h2>
                    <div class="space-y-4">
                        @foreach($shop->reviews->take(5) as $review)
                            <div class="p-4 rounded-xl bg-white/5">
                                <div class="flex items-center gap-3 mb-2">
                                    <img src="{{ $review->user->avatar_url }}" class="w-8 h-8 rounded-full" alt="">
                                    <div>
                                        <span class="text-white text-sm font-medium">{{ $review->user->name }}</span>
                                        <div class="flex gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-dark-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-dark-300 text-sm">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="glass-card p-6 sticky top-24">
                    <h3 class="font-display font-semibold text-lg text-white mb-4">Quick Info</h3>
                    <div class="space-y-4 text-sm">
                        @if($shop->phone)
                        <div class="flex items-center gap-3 text-dark-300">
                            <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $shop->phone }}
                        </div>
                        @endif
                        <div class="flex items-start gap-3 text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $shop->address }}
                        </div>
                        <div class="flex items-center gap-3 text-dark-300">
                            <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            {{ $shop->services->count() }} services available
                        </div>
                    </div>

                    @if($shop->timeSlots->count())
                    <div class="mt-6 pt-6 border-t border-white/10">
                        <h4 class="text-white font-medium mb-3">Opening Hours</h4>
                        <div class="space-y-2 text-sm">
                            @foreach($shop->timeSlots->sortBy('day_of_week') as $slot)
                                <div class="flex justify-between text-dark-300">
                                    <span>{{ $slot->day_name }}</span>
                                    <span class="{{ $slot->is_available ? 'text-emerald-400' : 'text-dark-500' }}">
                                        {{ $slot->is_available ? substr($slot->open_time, 0, 5) . ' - ' . substr($slot->close_time, 0, 5) : 'Closed' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <a href="{{ route('bookings.create.shop', $shop->slug) }}" class="btn-primary w-full mt-6 !py-4">Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
