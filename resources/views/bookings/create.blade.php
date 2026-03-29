<x-layouts.app title="Book Appointment">
    <section class="pt-28 pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" x-data="bookingForm()">
            <div class="mb-8">
                <h1 class="section-title">Book <span class="gradient-text">Appointment</span></h1>
                <p class="section-subtitle">
                    @if($providerType === 'shop')
                        at {{ $provider->name }}
                    @else
                        with {{ $provider->user->name }}
                    @endif
                </p>
            </div>

            {{-- Progress Steps --}}
            <div class="flex items-center justify-center gap-2 mb-10">
                @foreach(['Services', 'Date & Time', 'Details'] as $i => $stepName)
                    <div class="flex items-center gap-2">
                        <div :class="step > {{ $i }} ? 'bg-primary-600 text-white' : (step === {{ $i }} ? 'bg-primary-600/30 text-primary-300 border-primary-500' : 'bg-white/5 text-dark-500 border-white/10')"
                             class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border transition-all">{{ $i + 1 }}</div>
                        <span :class="step >= {{ $i }} ? 'text-white' : 'text-dark-500'" class="text-sm hidden sm:inline">{{ $stepName }}</span>
                        @if($i < 2)<div class="w-8 h-px bg-white/10 mx-1"></div>@endif
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="provider_type" value="{{ $providerType }}">
                <input type="hidden" name="provider_id" value="{{ $provider->id }}">

                {{-- STEP 1: Services --}}
                <div x-show="step === 0" x-transition class="glass-card p-6 md:p-8">
                    <h2 class="font-display font-semibold text-xl text-white mb-6">Select Services</h2>
                    <div class="space-y-3">
                        @foreach($services as $service)
                            <label class="flex items-center justify-between p-4 rounded-xl bg-white/5 hover:bg-white/10 cursor-pointer transition-colors border border-transparent"
                                   :class="selectedServices.includes({{ $service->id }}) ? 'border-primary-500 bg-primary-500/10' : ''">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                           x-model.number="selectedServices" :value="{{ $service->id }}"
                                           @change="updateTotal()" class="rounded border-white/20 bg-white/5 text-primary-500 focus:ring-primary-500">
                                    <div>
                                        <span class="text-white font-medium">{{ $service->name }}</span>
                                        <p class="text-dark-400 text-sm">{{ $service->description }}</p>
                                        <span class="text-dark-500 text-xs">⏱ {{ $service->formatted_duration }}</span>
                                    </div>
                                </div>
                                <span class="text-white font-semibold shrink-0 ml-4">${{ number_format($service->price, 0) }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <div>
                            <span class="text-dark-400 text-sm">Total:</span>
                            <span class="text-white font-display font-bold text-xl ml-2">$<span x-text="total"></span></span>
                        </div>
                        <button type="button" @click="if(selectedServices.length) step = 1" :disabled="!selectedServices.length"
                                class="btn-primary" :class="!selectedServices.length ? 'opacity-50 cursor-not-allowed' : ''">
                            Continue →
                        </button>
                    </div>
                </div>

                {{-- STEP 2: Date & Time --}}
                <div x-show="step === 1" x-transition class="glass-card p-6 md:p-8">
                    <h2 class="font-display font-semibold text-xl text-white mb-6">Choose Date & Time</h2>
                    <div class="mb-6">
                        <label class="text-dark-300 text-sm mb-2 block">Select Date</label>
                        <input type="date" name="booking_date" x-model="bookingDate" @change="fetchSlots()"
                               min="{{ date('Y-m-d') }}" class="input-dark max-w-xs">
                    </div>
                    <div x-show="bookingDate">
                        <label class="text-dark-300 text-sm mb-3 block">Available Time Slots</label>
                        <div x-show="loadingSlots" class="text-dark-400 text-sm py-4">Loading available slots...</div>
                        <div x-show="!loadingSlots" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                            <template x-for="slot in availableSlots" :key="slot.time">
                                <button type="button" @click="if(slot.available) selectedTime = slot.time"
                                        :class="slot.available ? (selectedTime === slot.time ? 'bg-primary-600 text-white border-primary-500' : 'bg-white/5 text-white hover:bg-white/10 border-white/10') : 'bg-white/5 text-dark-600 cursor-not-allowed border-white/5 line-through'"
                                        class="px-3 py-2 rounded-lg text-sm font-medium border transition-all text-center"
                                        :disabled="!slot.available"
                                        x-text="slot.display">
                                </button>
                            </template>
                        </div>
                        <div x-show="!loadingSlots && availableSlots.length === 0" class="text-dark-400 text-sm py-4">No slots available for this date.</div>
                        <input type="hidden" name="start_time" x-model="selectedTime">
                    </div>

                    @if($staff->count())
                    <div class="mt-6">
                        <label class="text-dark-300 text-sm mb-3 block">Preferred Staff (Optional)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-3 p-3 rounded-xl bg-white/5 cursor-pointer border border-transparent hover:bg-white/10"
                                   :class="!staffId ? 'border-primary-500 bg-primary-500/10' : ''">
                                <input type="radio" name="staff_member_id" value="" x-model="staffId" class="text-primary-500 focus:ring-primary-500">
                                <span class="text-dark-300 text-sm">Any available</span>
                            </label>
                            @foreach($staff as $member)
                                <label class="flex items-center gap-3 p-3 rounded-xl bg-white/5 cursor-pointer border border-transparent hover:bg-white/10"
                                       :class="staffId == '{{ $member->id }}' ? 'border-primary-500 bg-primary-500/10' : ''">
                                    <input type="radio" name="staff_member_id" value="{{ $member->id }}" x-model="staffId" class="text-primary-500 focus:ring-primary-500">
                                    <div>
                                        <span class="text-white text-sm">{{ $member->name }}</span>
                                        <span class="text-dark-400 text-xs block">{{ $member->title }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-6 flex items-center justify-between">
                        <button type="button" @click="step = 0" class="btn-secondary">← Back</button>
                        <button type="button" @click="if(selectedTime) step = 2" :disabled="!selectedTime"
                                class="btn-primary" :class="!selectedTime ? 'opacity-50 cursor-not-allowed' : ''">Continue →</button>
                    </div>
                </div>

                {{-- STEP 3: Details & Confirm --}}
                <div x-show="step === 2" x-transition class="glass-card p-6 md:p-8">
                    <h2 class="font-display font-semibold text-xl text-white mb-6">Confirm Details</h2>

                    @if($providerType === 'freelancer')
                    <div class="mb-4">
                        <label class="text-dark-300 text-sm mb-2 block">Your Address (for home service)</label>
                        <input type="text" name="customer_address" class="input-dark" placeholder="Enter your address">
                    </div>
                    @endif
                    <div class="mb-4">
                        <label class="text-dark-300 text-sm mb-2 block">Phone Number</label>
                        <input type="text" name="customer_phone" class="input-dark" placeholder="Your phone number">
                    </div>
                    <div class="mb-6">
                        <label class="text-dark-300 text-sm mb-2 block">Notes (optional)</label>
                        <textarea name="notes" class="input-dark h-24" placeholder="Any special requests..."></textarea>
                    </div>

                    {{-- Summary --}}
                    <div class="p-4 rounded-xl bg-white/5 mb-6">
                        <h3 class="text-white font-semibold mb-3">Booking Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-dark-300">
                                <span>Date</span><span class="text-white" x-text="bookingDate"></span>
                            </div>
                            <div class="flex justify-between text-dark-300">
                                <span>Time</span><span class="text-white" x-text="selectedTime"></span>
                            </div>
                            <div class="border-t border-white/10 my-2 pt-2 flex justify-between">
                                <span class="text-white font-semibold">Total</span>
                                <span class="text-primary-400 font-display font-bold text-lg">$<span x-text="total"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="button" @click="step = 1" class="btn-secondary">← Back</button>
                        <button type="submit" class="btn-primary !px-8 !py-4">✨ Confirm Booking</button>
                    </div>
                </div>
            </form>

            @if($errors->any())
                <div class="mt-4 glass-card p-4 border-l-4 border-red-500">
                    <ul class="text-red-400 text-sm space-y-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>

    <script>
    function bookingForm() {
        const prices = {!! json_encode($services->pluck('price', 'id')) !!};
        return {
            step: 0,
            selectedServices: [],
            bookingDate: '',
            selectedTime: '',
            staffId: '',
            total: 0,
            availableSlots: [],
            loadingSlots: false,
            updateTotal() {
                this.total = this.selectedServices.reduce((sum, id) => sum + (prices[id] || 0), 0);
            },
            async fetchSlots() {
                if (!this.bookingDate) return;
                this.loadingSlots = true;
                this.selectedTime = '';
                try {
                    const res = await fetch('{{ route("api.available-slots") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({
                            provider_type: '{{ $providerType }}',
                            provider_id: {{ $provider->id }},
                            date: this.bookingDate,
                        })
                    });
                    const data = await res.json();
                    this.availableSlots = data.slots || [];
                } catch (e) { this.availableSlots = []; }
                this.loadingSlots = false;
            }
        }
    }
    </script>
</x-layouts.app>
