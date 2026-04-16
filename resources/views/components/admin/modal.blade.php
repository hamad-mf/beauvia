{{-- resources/views/components/admin/modal.blade.php --}}
@props(['id', 'title'])

<div x-data="{ open: false }" 
     @open-modal-{{ $id }}.window="open = true"
     @close-modal-{{ $id }}.window="open = false"
     x-show="open" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div @click="open = false" class="fixed inset-0 bg-black/50 transition-opacity"></div>
        
        <div @click.away="open = false" 
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="relative glass-card p-6 w-full max-w-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-semibold text-lg text-gray-900">{{ $title }}</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
