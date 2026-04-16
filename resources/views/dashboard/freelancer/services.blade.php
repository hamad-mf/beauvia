{{-- resources/views/dashboard/freelancer/services.blade.php --}}
<x-layouts.dashboard title="Manage Services">
    <x-slot:sidebar>
        <a href="{{ route('freelancer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
            Overview
        </a>
        <a href="{{ route('freelancer.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            Bookings
        </a>
        <a href="{{ route('freelancer.services') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-50 text-primary-700 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/></svg>
            Services
        </a>
        <a href="{{ route('freelancers.show', $profile->id) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
            View Profile
        </a>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Add New Service</h3>
            <form method="POST" action="{{ route('freelancer.services.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-gray-700 text-sm mb-1 block">Service Name</label>
                    <input type="text" name="name" required class="input-dark" placeholder="e.g. Bridal Makeup">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-gray-700 text-sm mb-1 block">Price ($)</label>
                        <input type="number" name="price" step="0.01" required class="input-dark" placeholder="100">
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-1 block">Duration (min)</label>
                        <input type="number" name="duration_minutes" required class="input-dark" placeholder="60">
                    </div>
                </div>
                <div>
                    <label class="text-gray-700 text-sm mb-1 block">Description</label>
                    <textarea name="description" class="input-dark h-20" placeholder="Brief description..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Add Service</button>
            </form>
        </div>
        <div class="lg:col-span-2 glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Current Services ({{ $services->count() }})</h3>
            <div class="space-y-3">
                @forelse($services as $service)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50">
                        <div>
                            <h4 class="text-gray-900 font-medium">{{ $service->name }}</h4>
                            <p class="text-gray-500 text-sm">{{ $service->description }}</p>
                            <span class="text-gray-400 text-xs">⏱ {{ $service->formatted_duration }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-gray-900 font-semibold">${{ number_format($service->price, 0) }}</span>
                            <form method="POST" action="{{ route('freelancer.services.destroy', $service) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No services added yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>