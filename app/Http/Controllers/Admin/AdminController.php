<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Aggregate metrics
        $metrics = [
            'total_users' => User::count(),
            'total_shops' => Shop::count(),
            'total_freelancers' => FreelancerProfile::count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::where('status', 'completed')->sum('total_price'),
            'pending_approvals' => Shop::pending()->count() + FreelancerProfile::pending()->count(),
            'pending_reviews' => Review::flagged()->count(),
            'today_bookings' => Booking::whereDate('booking_date', today())->count(),
            'month_revenue' => Booking::where('status', 'completed')
                ->whereMonth('booking_date', now()->month)
                ->whereYear('booking_date', now()->year)
                ->sum('total_price'),
        ];
        
        // Chart data: bookings over last 30 days
        $bookingsChart = Booking::selectRaw('DATE(booking_date) as date, COUNT(*) as count')
            ->where('booking_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Recent activity
        $recentBookings = Booking::with(['user', 'bookable'])->latest()->take(10)->get();
        $recentUsers = User::latest()->take(10)->get();
        
        return view('admin.dashboard', compact('metrics', 'bookingsChart', 'recentBookings', 'recentUsers'));
    }
}
