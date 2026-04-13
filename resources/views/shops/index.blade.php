<x-layouts.app title="Shops">
    <section class="pt-28 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="section-title">Browse <span class="gradient-text">Shops</span></h1>
                <p class="section-subtitle">Find the perfect salon, spa, or barbershop</p>
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('shops.index') }}" class="badge {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} border border-gray-200 !text-sm !px-4 !py-2 transition-colors">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('shops.index', ['category' => $cat->slug, 'search' => request('search')]) }}"
                       class="badge {{ request('category') === $cat->slug ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} border border-gray-200 !text-sm !px-4 !py-2 transition-colors">
                        {{ $cat->icon }} {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Sort bar --}}
            <div class="flex items-center justify-between mb-6">
                <p class="text-gray-500 text-sm">{{ $shops->total() }} shops found</p>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 text-sm">Sort by:</span>
                    <select onchange="window.location.href=this.value" class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm text-gray-900 focus:border-primary-500 focus:outline-none">
                        @foreach(['recommended' => 'Recommended', 'rating' => 'Top Rated', 'reviews' => 'Most Reviews', 'name' => 'Name A-Z'] as $val => $label)
                            <option value="{{ route('shops.index', array_merge(request()->query(), ['sort' => $val])) }}" {{ request('sort', 'recommended') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Shop Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($shops as $shop)
                    <a href="{{ route('shops.show', $shop->slug) }}" class="glass-card-hover overflow-hidden group">
                        <div class="h-44 bg-gradient-to-br from-primary-50 to-gray-100 relative overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center opacity-20"><svg class="w-20 h-20 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg></div>
                            @if($shop->is_featured)
                                <div class="absolute top-3 left-3 badge bg-primary-50 text-primary-700 border border-primary-200"><svg class="w-3.5 h-3.5 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>Featured</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-1">
                                <h3 class="font-display font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $shop->name }}</h3>
                                <div class="flex items-center gap-1 text-sm shrink-0">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-gray-900 font-semibold">{{ number_format($shop->rating_avg, 1) }}</span>
                                    <span class="text-gray-400">({{ $shop->rating_count }})</span>
                                </div>
                            </div>
                            <p class="text-primary-600 text-sm mb-2">{{ $shop->category->name }}</p>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-3">{{ Str::limit($shop->description, 100) }}</p>
                            <div class="flex items-center gap-2 text-gray-400 text-xs mb-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ Str::limit($shop->address, 45) }}
                            </div>
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-gray-500 text-xs">From ${{ number_format($shop->services->min('price') ?? 0, 0) }}</span>
                                <span class="text-primary-600 text-xs font-medium group-hover:underline">View Details →</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center"><svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg></div>
                        <h3 class="font-display text-xl text-gray-900 mb-2">No shops found</h3>
                        <p class="text-gray-500">Try adjusting your filters or search terms</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">{{ $shops->withQueryString()->links() }}</div>
        </div>
    </section>
</x-layouts.app>
