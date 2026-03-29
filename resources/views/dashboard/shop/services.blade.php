<x-layouts.dashboard title="Manage Services">
    <x-slot:sidebar>
        <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5">📊 Overview</a>
        <a href="{{ route('shop.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5">📅 Bookings</a>
        <a href="{{ route('shop.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-600/20 text-primary-300">📦 Services</a>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Add Service Form --}}
        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-white mb-4">Add New Service</h3>
            <form method="POST" action="{{ route('shop.services.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-dark-300 text-sm mb-1 block">Service Name</label>
                    <input type="text" name="name" required class="input-dark" placeholder="e.g. Women's Haircut">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-dark-300 text-sm mb-1 block">Price ($)</label>
                        <input type="number" name="price" step="0.01" required class="input-dark" placeholder="50">
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-1 block">Duration (min)</label>
                        <input type="number" name="duration_minutes" required class="input-dark" placeholder="30">
                    </div>
                </div>
                <div>
                    <label class="text-dark-300 text-sm mb-1 block">Description</label>
                    <textarea name="description" class="input-dark h-20" placeholder="Brief description..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Add Service</button>
            </form>
        </div>

        {{-- Services List --}}
        <div class="lg:col-span-2 glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-white mb-4">Current Services ({{ $services->count() }})</h3>
            <div class="space-y-3">
                @forelse($services as $service)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-white/5">
                        <div>
                            <h4 class="text-white font-medium">{{ $service->name }}</h4>
                            <p class="text-dark-400 text-sm">{{ $service->description }}</p>
                            <span class="text-dark-500 text-xs">⏱ {{ $service->formatted_duration }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-white font-semibold">${{ number_format($service->price, 0) }}</span>
                            <form method="POST" action="{{ route('shop.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-dark-400 text-center py-8">No services added yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>
