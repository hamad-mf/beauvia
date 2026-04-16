<x-layouts.admin title="Shop Management">
    {{-- Status Filter Tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto">
        <a href="{{ route('admin.shops.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('status') ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.shops.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'pending' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Pending ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.shops.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'approved' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Approved ({{ $statusCounts['approved'] }})
        </a>
        <a href="{{ route('admin.shops.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'rejected' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Rejected ({{ $statusCounts['rejected'] }})
        </a>
    </div>

    {{-- Search/Filter Bar --}}
    <x-admin.filter-bar searchPlaceholder="Search by shop name, owner, or city..." />

    {{-- Data Table --}}
    <x-admin.data-table :headers="['Shop', 'Owner', 'Category', 'City', 'Services', 'Bookings', 'Reviews', 'Status', 'Actions']" :bulkActions="true">
        <x-slot:bulkActions>
            <div class="flex gap-2">
                <button @click="$dispatch('open-modal-bulk-approve')" class="btn-secondary text-xs">Approve</button>
                <button @click="$dispatch('open-modal-bulk-reject')" class="btn-secondary text-xs">Reject</button>
                <button @click="$dispatch('open-modal-bulk-suspend')" class="btn-secondary text-xs text-red-600">Suspend</button>
            </div>
        </x-slot:bulkActions>

        @forelse($shops as $shop)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <input type="checkbox" class="row-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500" value="{{ $shop->id }}" x-model="selected">
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-display font-bold">
                        {{ substr($shop->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-medium">{{ $shop->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $shop->slug }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $shop->user->name }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $shop->category->name }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $shop->city }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $shop->services_count }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $shop->bookings_count }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $shop->reviews_count }}</td>
            <td class="px-4 py-3">
                <x-admin.status-badge :status="$shop->approval_status" />
            </td>
            <td class="px-4 py-3">
                <a href="{{ route('admin.shops.show', $shop) }}" class="text-primary-600 hover:text-primary-700 text-sm">View</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="px-4 py-8 text-center text-gray-500">No shops found</td>
        </tr>
        @endforelse
    </x-admin.data-table>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $shops->links() }}
    </div>

    {{-- Bulk Action Modals --}}
    <x-admin.modal id="bulk-approve" title="Approve Shops">
        <form method="POST" action="{{ route('admin.shops.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="approve">
            <input type="hidden" name="shop_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to approve <span x-text="selected.length"></span> shop(s)?</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-approve')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Approve</button>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal id="bulk-reject" title="Reject Shops">
        <form method="POST" action="{{ route('admin.shops.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="reject">
            <input type="hidden" name="shop_ids" x-bind:value="JSON.stringify(selected)">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Rejection Reason</label>
                <textarea name="rejection_reason" rows="3" class="input-dark" required></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-reject')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Reject</button>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal id="bulk-suspend" title="Suspend Shops">
        <form method="POST" action="{{ route('admin.shops.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="suspend">
            <input type="hidden" name="shop_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to suspend <span x-text="selected.length"></span> shop(s)?</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-suspend')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Suspend</button>
            </div>
        </form>
    </x-admin.modal>
</x-layouts.admin>
