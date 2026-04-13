<x-layouts.app title="Sign In">
    <section class="pt-28 pb-20 min-h-screen flex items-center">
        <div class="max-w-md mx-auto w-full px-4">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-gray-900 mb-2">Welcome Back</h1>
                <p class="text-gray-500">Sign in to your Beauvia account</p>
            </div>
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="input-dark">
                        @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Password</label>
                        <input type="password" name="password" required class="input-dark">
                        @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 bg-white text-primary-500 focus:ring-primary-500">
                            Remember me
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary-600 text-sm hover:underline">Forgot password?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3.5">Sign In</button>
                </form>
                <p class="text-center text-gray-500 text-sm mt-6">Don't have an account? <a href="{{ route('register') }}" class="text-primary-600 hover:underline">Create one</a></p>
            </div>

            {{-- Demo accounts --}}
            <div class="mt-6 glass-card p-4">
                <p class="text-gray-500 text-xs text-center mb-3">Demo Accounts (password: <code class="text-primary-600 font-medium">password</code>)</p>
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <button onclick="document.querySelector('[name=email]').value='customer@beauvia.com'; document.querySelector('[name=password]').value='password'" class="px-2 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Customer</button>
                    <button onclick="document.querySelector('[name=email]').value='emma@beauvia.com'; document.querySelector('[name=password]').value='password'" class="px-2 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Shop Owner</button>
                    <button onclick="document.querySelector('[name=email]').value='olivia@beauvia.com'; document.querySelector('[name=password]').value='password'" class="px-2 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Freelancer</button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
