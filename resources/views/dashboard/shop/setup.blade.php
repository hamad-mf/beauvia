<x-layouts.app title="Setup Your Shop">
    <section class="pt-28 pb-20 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-white mb-2">Setup Your Shop</h1>
                <p class="text-dark-400">Tell us about your business to get started</p>
            </div>
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('shop.setup') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Shop Name</label>
                        <input type="text" name="name" required class="input-dark" placeholder="e.g. Luxe Hair Studio" value="{{ old('name') }}">
                        @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Category</label>
                        <select name="category_id" required class="input-dark">
                            <option value="">Select category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Description</label>
                        <textarea name="description" required class="input-dark h-28" placeholder="Describe your shop...">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Address</label>
                        <input type="text" name="address" required class="input-dark" placeholder="Full address" value="{{ old('address') }}">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-dark-300 text-sm mb-2 block">Phone</label>
                            <input type="text" name="phone" required class="input-dark" placeholder="+1-xxx-xxx-xxxx">
                        </div>
                        <div>
                            <label class="text-dark-300 text-sm mb-2 block">Email (optional)</label>
                            <input type="email" name="email" class="input-dark" placeholder="shop@email.com">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full !py-4">Create Shop →</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
