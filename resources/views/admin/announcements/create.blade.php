<x-layouts.admin title="Create Announcement">
    <div class="mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">← Back to Announcements</a>
    </div>

    <div class="max-w-2xl">
        <div class="glass-card p-6">
            <form method="POST" action="{{ route('admin.announcements.store') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="input-dark" required>
                    @error('title')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Message</label>
                    <textarea name="message" rows="4" class="input-dark" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Type</label>
                    <select name="type" class="input-dark" required>
                        <option value="info" {{ old('type') === 'info' ? 'selected' : '' }}>Info</option>
                        <option value="warning" {{ old('type') === 'warning' ? 'selected' : '' }}>Warning</option>
                        <option value="success" {{ old('type') === 'success' ? 'selected' : '' }}>Success</option>
                    </select>
                    @error('type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Target Audience</label>
                    <select name="target_role" class="input-dark" required>
                        <option value="all" {{ old('target_role') === 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="customer" {{ old('target_role') === 'customer' ? 'selected' : '' }}>Customers</option>
                        <option value="shop_owner" {{ old('target_role') === 'shop_owner' ? 'selected' : '' }}>Shop Owners</option>
                        <option value="freelancer" {{ old('target_role') === 'freelancer' ? 'selected' : '' }}>Freelancers</option>
                    </select>
                    @error('target_role')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" class="input-dark" required>
                    @error('start_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', now()->addDays(7)->format('Y-m-d')) }}" class="input-dark" required>
                    @error('end_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-700 text-sm font-medium">Active</span>
                    </label>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Create Announcement</button>
                    <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
