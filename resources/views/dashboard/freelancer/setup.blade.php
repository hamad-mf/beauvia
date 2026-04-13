{{-- resources/views/dashboard/freelancer/setup.blade.php --}}
<x-layouts.app title="Setup Your Profile">
    <section class="pt-28 pb-20 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-gray-900 mb-2">Setup Your Profile</h1>
                <p class="text-gray-500">Create your freelancer profile to start receiving bookings</p>
            </div>
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('freelancer.setup') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Category</label>
                        <select name="category_id" required class="input-dark">
                            <option value="">Select your specialty...</option>
                            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Professional Title</label>
                        <input type="text" name="title" required class="input-dark" placeholder="e.g. Celebrity Makeup Artist" value="{{ old('title') }}">
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Bio</label>
                        <textarea name="bio" required class="input-dark h-28" placeholder="Tell clients about yourself...">{{ old('bio') }}</textarea>
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Specialization</label>
                        <input type="text" name="specialization" required class="input-dark" placeholder="e.g. Bridal & Editorial" value="{{ old('specialization') }}">
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="text-gray-700 text-sm mb-2 block">Experience (years)</label>
                            <input type="number" name="experience_years" required class="input-dark" placeholder="5" value="{{ old('experience_years') }}">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm mb-2 block">Hourly Rate ($)</label>
                            <input type="number" name="hourly_rate" step="0.01" required class="input-dark" placeholder="100" value="{{ old('hourly_rate') }}">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm mb-2 block">Service Radius (km)</label>
                            <input type="number" name="service_radius_km" required class="input-dark" placeholder="15" value="{{ old('service_radius_km', 15) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full !py-4">Create Profile →</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>