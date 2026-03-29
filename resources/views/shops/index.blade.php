<x-layouts.app title="Shops">
    <section class="pt-28 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="section-title">Browse <span class="gradient-text">Shops</span></h1>
                <p class="section-subtitle">Find the perfect salon, spa, or barbershop</p>
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('shops.index') }}" class="badge {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-white/5 text-dark-300 hover:bg-white/10' }} border border-white/10 !text-sm !px-4 !py-2 transition-colors">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('shops.index', ['category' => $cat->slug, 'search' => request('search')]) }}"
                       class="badge {{ request('category') === $cat->slug ? 'bg-primary-600 text-white' : 'bg-white/5 text-dark-300 hover:bg-white/10' }} border border-white/10 !text-sm !px-4 !py-2 transition-colors">
                        {{ $cat->icon }} {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Sort bar --}}
            <div class="flex items-center justify-between mb-6">
                <p class="text-dark-400 text-sm">{{ $shops->total() }} shops found</p>
                <div class="flex items-center gap-2">
                    <span class="text-dark-400 text-sm">Sort by:</span>
                    <select onchange="window.location.href=this.value" class="bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-sm text-white focus:border-primary-500 focus:outline-none">
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
                        <div class="h-44 bg-gradient-to-br from-primary-900/50 to-dark-800 relative overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center text-6xl opacity-20">{{ $shop->category->icon ?? '✨' }}</div>
                            @if($shop->is_featured)
                                <div class="absolute top-3 left-3 badge bg-primary-500/20 text-primary-300 border border-primary-500/30">⭐ Featured</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-1">
                                <h3 class="font-display font-semibold text-white group-hover:text-primary-300 transition-colors">{{ $shop->name }}</h3>
                                <div class="flex items-center gap-1 text-sm shrink-0">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-white font-semibold">{{ number_format($shop->rating_avg, 1) }}</span>
                                    <span class="text-dark-400">({{ $shop->rating_count }})</span>
                                </div>
                            </div>
                            <p class="text-primary-400 text-sm mb-2">{{ $shop->category->name }}</p>
                            <p class="text-dark-400 text-sm line-clamp-2 mb-3">{{ Str::limit($shop->description, 100) }}</p>
                            <div class="flex items-center gap-2 text-dark-500 text-xs mb-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ Str::limit($shop->address, 45) }}
                            </div>
                            <div class="pt-3 border-t border-white/5 flex items-center justify-between">
                                <span class="text-dark-400 text-xs">From ${{ number_format($shop->services->min('price') ?? 0, 0) }}</span>
                                <span class="text-primary-400 text-xs font-medium group-hover:underline">View Details →</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="text-5xl mb-4">🔍</div>
                        <h3 class="font-display text-xl text-white mb-2">No shops found</h3>
                        <p class="text-dark-400">Try adjusting your filters or search terms</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">{{ $shops->withQueryString()->links() }}</div>
        </div>
    </section>
</x-layouts.app>
