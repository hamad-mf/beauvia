<x-layouts.admin title="Edit Category">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">← Back to Categories</a>
    </div>

    <div class="max-w-2xl">
        <div class="glass-card p-6">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="input-dark" required>
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="input-dark" required>
                    <p class="text-gray-500 text-xs mt-1">URL-friendly version (e.g., hair-salon)</p>
                    @error('slug')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Icon (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="input-dark" required maxlength="10">
                    <p class="text-gray-500 text-xs mt-1">Single emoji character (e.g., 💇)</p>
                    @error('icon')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
