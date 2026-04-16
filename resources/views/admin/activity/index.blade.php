<x-layouts.admin title="Activity Log">
    {{-- Search/Filter Bar --}}
    <x-admin.filter-bar searchPlaceholder="Search activities...">
        <select name="action" class="input-dark">
            <option value="">All Actions</option>
            @foreach($actions as $action)
                <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $action)) }}</option>
            @endforeach
        </select>
        <select name="admin_id" class="input-dark">
            <option value="">All Admins</option>
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
            @endforeach
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-dark" placeholder="From Date">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-dark" placeholder="To Date">
    </x-admin.filter-bar>

    {{-- Activity List --}}
    <div class="glass-card">
        <div class="divide-y divide-gray-200">
            @forelse($activities as $activity)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <img src="{{ $activity->admin->avatar_url }}" class="w-10 h-10 rounded-full" alt="">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-gray-900 font-medium">{{ $activity->admin->name }}</span>
                                <span class="badge bg-gray-100 text-gray-700 text-xs">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-1">
                                @if($activity->subject_type && $activity->subject_id)
                                    {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                @endif
                            </p>
                            @if($activity->metadata)
                                <div class="text-xs text-gray-500 font-mono bg-gray-50 p-2 rounded mt-2">
                                    {{ json_encode($activity->metadata, JSON_PRETTY_PRINT) }}
                                </div>
                            @endif
                            <div class="flex items-center gap-4 text-xs text-gray-500 mt-2">
                                <span>{{ $activity->created_at->format('M d, Y g:i A') }}</span>
                                <span>IP: {{ $activity->ip_address }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">No activity logs found</div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $activities->links() }}
    </div>
</x-layouts.admin>
