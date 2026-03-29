<x-layouts.app title="Register">
    <section class="pt-28 pb-20 min-h-screen flex items-center">
        <div class="max-w-md mx-auto w-full px-4">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-white mb-2">Get Started</h1>
                <p class="text-dark-400">Create your Beauvia account</p>
            </div>
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ role: 'customer' }">
                    @csrf
                    {{-- Role Selection --}}
                    <div>
                        <label class="text-dark-300 text-sm mb-3 block">I want to</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(['customer' => ['💳', 'Book Services'], 'shop_owner' => ['🏪', 'List My Shop'], 'freelancer' => ['💼', 'Work Freelance']] as $val => [$icon, $label])
                                <label class="cursor-pointer">
                                    <input type="radio" name="role" value="{{ $val }}" x-model="role" class="hidden peer">
                                    <div class="p-3 rounded-xl bg-white/5 border border-white/10 text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-500/10 hover:bg-white/10">
                                        <div class="text-xl mb-1">{{ $icon }}</div>
                                        <span class="text-xs text-dark-300">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="input-dark">
                        @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-dark">
                        @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Password</label>
                        <input type="password" name="password" required class="input-dark">
                        @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-dark-300 text-sm mb-2 block">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="input-dark">
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3.5">Create Account</button>
                </form>
                <p class="text-center text-dark-400 text-sm mt-6">Already have an account? <a href="{{ route('login') }}" class="text-primary-400 hover:underline">Sign in</a></p>
            </div>
        </div>
    </section>
</x-layouts.app>
