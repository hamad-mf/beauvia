<x-layouts.app :title="$freelancer->user->name">
    <section class="pt-28 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Profile header --}}
                    <div class="glass-card p-6 md:p-8">
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <div class="relative">
                                <img src="{{ $freelancer->user->avatar_url }}" class="w-24 h-24 rounded-2xl border-2 border-primary-500/50" alt="">
                                @if($freelancer->is_available)
                                    <span class="absolute -bottom-1 -right-1 badge bg-emerald-500 text-white text-xs !px-2">● Online</span>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-1">
                                    <h1 class="font-display text-2xl md:text-3xl font-bold text-gray-900">{{ $freelancer->user->name }}</h1>
                                </div>
                                <p class="text-primary-600 font-medium mb-1">{{ $freelancer->title }}</p>
                                <p class="text-gray-500 text-sm mb-3">{{ $freelancer->category->name }} • {{ $freelancer->specialization }}</p>
                                <div class="flex flex-wrap items-center gap-4 text-sm">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-gray-900 font-semibold">{{ number_format($freelancer->rating_avg, 1) }}</span>
                                        <span class="text-gray-400">({{ $freelancer->rating_count }} reviews)</span>
                                    </div>
                                    <span class="badge bg-blue-50 text-blue-700 border border-blue-200">{{ $freelancer->experience_years }} years experience</span>
                                    @if($freelancer->is_mobile)
                                        <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200"><svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>Travels to you ({{ $freelancer->service_radius_km }}km)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- About --}}
                    <div class="glass-card p-6">
                        <h2 class="font-display font-semibold text-xl text-gray-900 mb-4">About</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $freelancer->bio }}</p>
                    </div>

                    {{-- Services --}}
                    <div class="glass-card p-6">
                        <h2 class="font-display font-semibold text-xl text-gray-900 mb-6">Services</h2>
                        <div class="space-y-4">
                            @foreach($freelancer->services as $service)
                                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div>
                                        <h3 class="text-gray-900 font-medium">{{ $service->name }}</h3>
                                        <p class="text-gray-500 text-sm mt-1">{{ $service->description }}</p>
                                        <span class="text-gray-400 text-xs">⏱ {{ $service->formatted_duration }}</span>
                                    </div>
                                    <div class="text-right shrink-0 ml-4">
                                        <span class="text-gray-900 font-semibold text-lg">${{ number_format($service->price, 0) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div class="glass-card p-6">
                        <h2 class="font-display font-semibold text-xl text-gray-900 mb-6">Reviews ({{ $freelancer->rating_count }})</h2>
                        <div class="space-y-4">
                            @foreach($freelancer->reviews->take(5) as $review)
                                <div class="p-4 rounded-xl bg-gray-50">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="{{ $review->user->avatar_url }}" class="w-8 h-8 rounded-full" alt="">
                                        <div>
                                            <span class="text-gray-900 text-sm font-medium">{{ $review->user->name }}</span>
                                            <div class="flex gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    <div class="glass-card p-6 sticky top-24">
                        <div class="text-center mb-4">
                            <span class="text-3xl font-display font-bold gradient-text">${{ number_format($freelancer->hourly_rate, 0) }}</span>
                            <span class="text-gray-500">/hour</span>
                        </div>

                        @if($freelancer->timeSlots->count())
                        <div class="mb-6">
                            <h4 class="text-gray-900 font-medium mb-3 text-sm">Availability</h4>
                            <div class="space-y-2 text-sm">
                                @foreach($freelancer->timeSlots->sortBy('day_of_week') as $slot)
                                    <div class="flex justify-between text-gray-600">
                                        <span>{{ $slot->day_name }}</span>
                                        <span class="text-emerald-600">{{ substr($slot->open_time, 0, 5) }} - {{ substr($slot->close_time, 0, 5) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <a href="{{ route('bookings.create.freelancer', $freelancer->id) }}" class="btn-primary w-full !py-4 mb-3">Book Now</a>
                        <a href="{{ route('bookings.create.freelancer', $freelancer->id) }}" class="btn-secondary w-full !py-3 text-sm gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>Request Home Service</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
