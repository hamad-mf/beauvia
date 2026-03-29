<x-layouts.app title="Booking Confirmed">
    <section class="pt-28 pb-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="glass-card p-8 md:p-12">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-emerald-500/20 flex items-center justify-center animate-glow">
                    <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="font-display text-3xl font-bold text-white mb-2">Booking Confirmed!</h1>
                <p class="text-dark-400 mb-8">Your appointment has been booked successfully</p>

                <div class="text-left p-6 rounded-2xl bg-white/5 mb-8">
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-dark-400">Booking Code</span>
                            <span class="text-primary-400 font-mono font-semibold">{{ $booking->booking_code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark-400">Provider</span>
                            <span class="text-white">{{ $booking->provider_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark-400">Date</span>
                            <span class="text-white">{{ $booking->booking_date->format('l, M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark-400">Time</span>
                            <span class="text-white">{{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('g:i A') }} — {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('g:i A') }}</span>
                        </div>
                        @if($booking->staffMember)
                        <div class="flex justify-between">
                            <span class="text-dark-400">Staff</span>
                            <span class="text-white">{{ $booking->staffMember->name }}</span>
                        </div>
                        @endif
                        <div class="border-t border-white/10 pt-3 mt-3">
                            <h4 class="text-dark-400 mb-2">Services:</h4>
                            @foreach($booking->services as $svc)
                                <div class="flex justify-between text-dark-300">
                                    <span>{{ $svc->name }}</span>
                                    <span>${{ number_format($svc->pivot->price, 0) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-white/10 pt-3 flex justify-between">
                            <span class="text-white font-semibold">Total</span>
                            <span class="font-display font-bold text-lg gradient-text">${{ number_format($booking->total_price, 0) }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('home') }}" class="btn-secondary">Back to Home</a>
                    <a href="{{ route('customer.bookings') }}" class="btn-primary">View My Bookings</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
