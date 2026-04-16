<x-layouts.admin title="User Management">
    {{-- Role Filter Tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('role') ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            All ({{ $userCounts['all'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('role') === 'customer' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Customers ({{ $userCounts['customer'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'shop_owner']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('role') === 'shop_owner' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Shop Owners ({{ $userCounts['shop_owner'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'freelancer']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('role') === 'freelancer' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Freelancers ({{ $userCounts['freelancer'] }})
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('role') === 'admin' ? 'bg-primary-50 text-primary-700' : 'bg-white text-gray-600 hover:bg-gray-50' }} transition-colors whitespace-nowrap">
            Admins ({{ $userCounts['admin'] }})
        </a>
    </div>

    {{-- Search/Filter Bar --}}
    <x-admin.filter-bar searchPlaceholder="Search by name, email, or phone..." />

    {{-- Data Table --}}
    <x-admin.data-table :headers="['User', 'Email', 'Role', 'Bookings', 'Reviews', 'Status', 'Joined', 'Actions']" :bulkActions="true">
        <x-slot:bulkActions>
            <div class="flex gap-2">
                <button @click="$dispatch('open-modal-bulk-suspend')" class="btn-secondary text-xs">Suspend</button>
                <button @click="$dispatch('open-modal-bulk-reactivate')" class="btn-secondary text-xs">Reactivate</button>
                <button @click="$dispatch('open-modal-bulk-delete')" class="btn-secondary text-xs text-red-600">Delete</button>
            </div>
        </x-slot:bulkActions>

        @forelse($users as $user)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <input type="checkbox" class="row-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500" value="{{ $user->id }}" x-model="selected">
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full" alt="">
                    <div>
                        <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $user->phone ?? 'No phone' }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
            <td class="px-4 py-3">
                <span class="badge bg-gray-100 text-gray-700 capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->bookings_count }}</td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->reviews_count }}</td>
            <td class="px-4 py-3">
                @if($user->is_suspended)
                    <x-admin.status-badge status="suspended" />
                @else
                    <x-admin.status-badge status="active" />
                @endif
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
            <td class="px-4 py-3">
                <a href="{{ route('admin.users.show', $user) }}" class="text-primary-600 hover:text-primary-700 text-sm">View</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="px-4 py-8 text-center text-gray-500">No users found</td>
        </tr>
        @endforelse
    </x-admin.data-table>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>

    {{-- Bulk Action Modals --}}
    <x-admin.modal id="bulk-suspend" title="Suspend Users">
        <form method="POST" action="{{ route('admin.users.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="suspend">
            <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to suspend <span x-text="selected.length"></span> user(s)?</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-suspend')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Suspend</button>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal id="bulk-reactivate" title="Reactivate Users">
        <form method="POST" action="{{ route('admin.users.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="reactivate">
            <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to reactivate <span x-text="selected.length"></span> user(s)?</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-reactivate')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Reactivate</button>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal id="bulk-delete" title="Delete Users">
        <form method="POST" action="{{ route('admin.users.bulk') }}">
            @csrf
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selected)">
            <p class="text-gray-600 mb-4">Are you sure you want to delete <span x-text="selected.length"></span> user(s)? This action cannot be undone.</p>
            <div class="flex gap-3 justify-end">
                <button type="button" @click="$dispatch('close-modal-bulk-delete')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Delete</button>
            </div>
        </form>
    </x-admin.modal>
</x-layouts.admin>
