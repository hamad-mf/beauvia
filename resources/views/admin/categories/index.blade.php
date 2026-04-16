<x-layouts.admin title="Category Management">
    <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">Manage service categories and their display order</p>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Category
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="space-y-3">
            @forelse($categories as $category)
                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="text-2xl">{{ $category->icon }}</div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $category->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $category->slug }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">{{ $category->shops_count }}</span> shops, 
                            <span class="font-medium">{{ $category->freelancers_count }}</span> freelancers
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-primary-600 hover:text-primary-700 text-sm">Edit</a>
                            @if($category->shops_count === 0 && $category->freelancers_count === 0)
                                <button @click="$dispatch('open-modal-delete-{{ $category->id }}')" class="text-red-600 hover:text-red-700 text-sm">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Delete Modal --}}
                <x-admin.modal id="delete-{{ $category->id }}" title="Delete Category">
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                        @csrf @method('DELETE')
                        <p class="text-gray-600 mb-4">Are you sure you want to delete the category "{{ $category->name }}"?</p>
                        <div class="flex gap-3 justify-end">
                            <button type="button" @click="$dispatch('close-modal-delete-{{ $category->id }}')" class="btn-secondary">Cancel</button>
                            <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">Delete</button>
                        </div>
                    </form>
                </x-admin.modal>
            @empty
                <p class="text-gray-500 text-center py-8">No categories yet</p>
            @endforelse
        </div>
    </div>
</x-layouts.admin>
