<x-layouts.admin title="Announcements">
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Manage platform-wide announcements</p>
        <a href="{{ route('admin.announcements.create') }}" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Announcement
        </a>
    </div>

    <div class="glass-card">
        <div class="divide-y divide-gray-200">
            @forelse($announcements as $announcement)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-display font-semibold text-lg text-gray-900">{{ $announcement->title }}</h3>
                                @if($announcement->is_active)
                                    <span class="badge bg-emerald-100 text-emerald-700">Active</span>
                                @else
                                    <span class="badge bg-gray-100 text-gray-700">Inactive</span>
                                @endif
                                <span class="badge {{ $announcement->type === 'info' ? 'bg-blue-100 text-blue-700' : ($announcement->type === 'warning' ? 'bg-yellow-100 text-yellow-700' : 'bg-emerald-100 text-emerald-700') }}">
                                    {{ ucfirst($announcement->type) }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-2">{{ $announcement->message }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span>Target: <span class="font-medium capitalize">{{ str_replace('_', ' ', $announcement->target_role) }}</span></span>
                                <span>Start: {{ $announcement->start_date->format('M d, Y') }}</span>
                                <span>End: {{ $announcement->end_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-primary-600 hover:text-primary-700 text-sm">Edit</a>
                            <button @click="$dispatch('open-modal-delete-{{ $announcement->id }}')" class="text-red-600 hover:text-red-700 text-sm">Delete</button>
                        </div>
                    </div>
                </div>

                {{-- Delete Modal --}}
                <x-admin.modal id="delete-{{ $announcement->id }}" title="Delete Announcement">
                    <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}">
                        @csrf @method('DELETE')
                        <p class="text-gray-600 mb-4">Are you sure you want to delete the announcement "{{ $announcement->title }}"?</p>
                        <div class="flex gap-3 justify-end">
                            <button type="button" @click="$dispatch('close-modal-delete-{{ $announcement->id }}')" class="btn-secondary">Cancel</button>
                            <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Delete</button>
                        </div>
                    </form>
                </x-admin.modal>
            @empty
                <div class="p-8 text-center text-gray-500">No announcements yet</div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
</x-layouts.admin>
