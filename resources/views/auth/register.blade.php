<x-layouts.app title="Register">
    <section class="pt-28 pb-20 min-h-screen flex items-center">
        <div class="max-w-md mx-auto w-full px-4">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-gray-900 mb-2">Get Started</h1>
                <p class="text-gray-500">Create your Beauvia account</p>
            </div>
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ role: 'customer' }">
                    @csrf
                    {{-- Role Selection --}}
                    <div>
                        <label class="text-gray-700 text-sm mb-3 block">I want to</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="customer" x-model="role" class="hidden peer">
                                <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-100">
                                    <svg class="w-6 h-6 mx-auto mb-1.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                                    <span class="text-xs text-gray-600">Book Services</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="shop_owner" x-model="role" class="hidden peer">
                                <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-100">
                                    <svg class="w-6 h-6 mx-auto mb-1.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/></svg>
                                    <span class="text-xs text-gray-600">List My Shop</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="freelancer" x-model="role" class="hidden peer">
                                <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-100">
                                    <svg class="w-6 h-6 mx-auto mb-1.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                                    <span class="text-xs text-gray-600">Work Freelance</span>
                                </div>
                            </label>
                        </div>
                        @error('role')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="input-dark">
                        @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-dark">
                        @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Password</label>
                        <input type="password" name="password" required class="input-dark">
                        @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm mb-2 block">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="input-dark">
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3.5">Create Account</button>
                </form>
                <p class="text-center text-gray-500 text-sm mt-6">Already have an account? <a href="{{ route('login') }}" class="text-primary-600 hover:underline">Sign in</a></p>
            </div>
        </div>
    </section>
</x-layouts.app>
