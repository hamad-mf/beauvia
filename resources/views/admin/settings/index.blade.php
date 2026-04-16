<x-layouts.admin title="System Settings">
    <div class="max-w-3xl">
        <div class="glass-card p-6">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf @method('PATCH')
                
                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">General Settings</h3>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Commission Rate (%)</label>
                    <input type="number" name="commission_rate" value="{{ old('commission_rate', \App\Models\Setting::get('commission_rate', 10)) }}" class="input-dark" min="0" max="100" step="0.1" required>
                    <p class="text-gray-500 text-xs mt-1">Platform commission percentage on bookings</p>
                    @error('commission_rate')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="allow_new_providers" value="1" {{ old('allow_new_providers', \App\Models\Setting::get('allow_new_providers', true)) ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-700 text-sm font-medium">Allow New Provider Registrations</span>
                    </label>
                    <p class="text-gray-500 text-xs mt-1 ml-6">Enable shops and freelancers to register</p>
                </div>

                <div class="mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="allow_bookings" value="1" {{ old('allow_bookings', \App\Models\Setting::get('allow_bookings', true)) ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-700 text-sm font-medium">Allow New Bookings</span>
                    </label>
                    <p class="text-gray-500 text-xs mt-1 ml-6">Enable customers to create bookings</p>
                </div>

                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4 mt-8">Booking Settings</h3>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Cancellation Window (hours)</label>
                    <input type="number" name="cancellation_hours" value="{{ old('cancellation_hours', \App\Models\Setting::get('cancellation_hours', 24)) }}" class="input-dark" min="0" required>
                    <p class="text-gray-500 text-xs mt-1">Minimum hours before booking to allow cancellation</p>
                    @error('cancellation_hours')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Minimum Booking Advance (hours)</label>
                    <input type="number" name="min_booking_advance_hours" value="{{ old('min_booking_advance_hours', \App\Models\Setting::get('min_booking_advance_hours', 2)) }}" class="input-dark" min="0" required>
                    <p class="text-gray-500 text-xs mt-1">Minimum hours in advance to book</p>
                    @error('min_booking_advance_hours')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Maximum Booking Advance (days)</label>
                    <input type="number" name="max_booking_advance_days" value="{{ old('max_booking_advance_days', \App\Models\Setting::get('max_booking_advance_days', 90)) }}" class="input-dark" min="1" required>
                    <p class="text-gray-500 text-xs mt-1">Maximum days in advance to book</p>
                    @error('max_booking_advance_days')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <h3 class="font-display font-semibold text-lg text-gray-900 mb-4 mt-8">Notification Settings</h3>

                <div class="mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="email_notifications_enabled" value="1" {{ old('email_notifications_enabled', \App\Models\Setting::get('email_notifications_enabled', true)) ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-gray-700 text-sm font-medium">Enable Email Notifications</span>
                    </label>
                    <p class="text-gray-500 text-xs mt-1 ml-6">Send email notifications for approvals, rejections, etc.</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
