<x-layouts.admin title="Dashboard">
    {{-- Metrics Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-admin.stat-card title="Total Users" :value="$metrics['total_users']" color="gray" />
        <x-admin.stat-card title="Total Shops" :value="$metrics['total_shops']" color="blue" />
        <x-admin.stat-card title="Total Freelancers" :value="$metrics['total_freelancers']" color="emerald" />
        <x-admin.stat-card title="Total Bookings" :value="$metrics['total_bookings']" color="gray" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-admin.stat-card title="Total Revenue" :value="'$' . number_format($metrics['total_revenue'], 0)" color="primary" />
        <x-admin.stat-card title="Pending Approvals" :value="$metrics['pending_approvals']" color="yellow" />
        <x-admin.stat-card title="Flagged Reviews" :value="$metrics['pending_reviews']" color="red" />
        <x-admin.stat-card title="Today's Bookings" :value="$metrics['today_bookings']" color="emerald" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Bookings Chart --}}
        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Bookings (Last 30 Days)</h3>
            <canvas id="bookingsChart" height="200"></canvas>
        </div>

        {{-- Quick Stats --}}
        <div class="glass-card p-6">
            <h3 class="font-display font-semibold text-lg text-gray-900 mb-4">Quick Stats</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <span class="text-gray-600 text-sm">Month Revenue</span>
                    <span class="text-gray-900 font-semibold">${{ number_format($metrics['month_revenue'], 0) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <span class="text-gray-600 text-sm">Avg. Booking Value</span>
                    <span class="text-gray-900 font-semibold">${{ $metrics['total_bookings'] > 0 ? number_format($metrics['total_revenue'] / $metrics['total_bookings'], 0) : 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <span class="text-gray-600 text-sm">Active Providers</span>
                    <span class="text-gray-900 font-semibold">{{ $metrics['total_shops'] + $metrics['total_freelancers'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Bookings --}}
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display font-semibold text-lg text-gray-900">Recent Bookings</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-primary-600 text-sm hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div>
                            <p class="text-gray-900 text-sm font-medium">{{ $booking->user->name ?? 'Customer' }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->bookable->name ?? $booking->bookable->user->name ?? 'Provider' }} • {{ $booking->booking_date->format('M d') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-admin.status-badge :status="$booking->status" />
                            <span class="text-gray-900 text-sm">${{ number_format($booking->total_price, 0) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No bookings yet</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-display font-semibold text-lg text-gray-900">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-primary-600 text-sm hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full" alt="">
                            <div>
                                <p class="text-gray-900 text-sm font-medium">{{ $user->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="badge bg-gray-100 text-gray-700 capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No users yet</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bookingsChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($bookingsChart->pluck('date')),
                datasets: [{
                    label: 'Bookings',
                    data: @json($bookingsChart->pluck('count')),
                    borderColor: 'rgb(124, 58, 237)',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-layouts.admin>
