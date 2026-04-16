<x-layouts.admin title="Review Moderation">
    {{-- Filter Tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto">
        <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('flagged') ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            All Reviews
        </a>
        <a href="{{ route('admin.reviews.index', ['flagged' => '1']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('flagged') === '1' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Flagged ({{ $flaggedCount }})
        </a>
    </div>

    {{-- Search/Filter Bar --}}
    <x-admin.filter-bar searchPlaceholder="Search by comment, customer, or provider...">
        <select name="rating" class="input-dark">
            <option value="">All Ratings</option>
            <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 Stars</option>
            <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4 Stars</option>
            <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3 Stars</option>
            <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2 Stars</option>
            <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1 Star</option>
        </select>
        <select name="provider_type" class="input-dark">
            <option value="">All Providers</option>
            <option value="shop" {{ request('provider_type') === 'shop' ? 'selected' : '' }}>Shops</option>
            <option value="freelancer" {{ request('provider_type') === 'freelancer' ? 'selected' : '' }}>Freelancers</option>
        </select>
    </x-admin.filter-bar>

    {{-- Data Table --}}
    <x-admin.data-table :headers="['Customer', 'Provider', 'Rating', 'Comment', 'Date', 'Status', 'Actions']" :bulkActions="true">
        <x-slot:bulkActions>
            <div class="flex gap-2">
                <button @click="$dispatch('open-modal-bulk-flag')" class="btn-secondary text-xs">Flag</button>
                <button @click="$dispatch('open-modal-bulk-delete')" class="btn-secondary text-xs text-red-600">Delete</button>
            </div>
        </x-slot:bulkActions>

        @forelse($reviews as $review)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <input type="checkbox" class="row-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500" value="{{ $review->id }}" x-model="selected">
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <img src="{{ $review->user->avatar_url }}" class="w-8 h-8 rounded-full" alt="">
                    <p class="text-gray-900 font-medium text-sm">{{ $review->user->name }}</p>
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $review->reviewable->name ?? $review->reviewable->user->name ?? 'Provider' }}</td>
            <td class="px-4 py-3">
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">{{ $review->comment }}</td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</td>
            <td class="px-4 py-3">
                @if($review->is_flagged)
                    <span class="badge bg-red-100 text-red-700">Flagged</span>
                @else
                    <span class="badge bg-gray-100 text-gray-700">Normal</span>
                @endif
            </td>
            <td class="px-4 py-3">
                <div class="flex gap-2">
                    @if(!$review->is_flagged)
                        <form method="POST" action="{{ route('admin.reviews.flag', $review) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-yellow-600 hover:text-yellow-700 text-sm">Flag</button>
                        </form>
                    @endif
                    <button @click="$dispatch('open-modal-delete-{{ $review->id }}')" class="text-red-600 hover:text-red-700 text-sm">Delete</button>
                </div>
            </td>
        </tr>

        {{-- Delete Modal --}}
        <x-admin.modal id="delete-{{ $review->id }}" title="Delete Review">
            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                @csrf @method('DELETE')
                <p class="text-gray-600 mb-4">Are you sure you want to delete this review? The provider's rating will be recalculated.</p>
                <div class="flex gap-3 justify-end">
                    <button type="button" @click="$dispatch('close-modal-delete-{{ $review->id }}')" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Delete</button>
                </div>
            </form>
        </x-admin.modal>
        @empty
        <tr>
            <td colspan="8" class="px-4 py-8 text-center text-gray-500">No reviews found</td>
        </tr>
        @endforelse
    </x-admin.data-table>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $reviews->links() }}
    </div>

    {{-- Bulk Action Modals --}}
    <x-admin.modal id="bulk-flag" title="Flag Reviews">
        <form method="POST" action="{{ route('admin.reviews.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="flag">
            <input type="hidden" name="review_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to flag <span x-text="selected.length"></span> review(s)?</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-flag')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Flag</button>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal id="bulk-delete" title="Delete Reviews">
        <form method="POST" action="{{ route('admin.reviews.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="review_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to delete <span x-text="selected.length"></span> review(s)? Provider ratings will be recalculated.</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-delete')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Delete</button>
            </div>
        </form>
    </x-admin.modal>
</x-layouts.admin>
