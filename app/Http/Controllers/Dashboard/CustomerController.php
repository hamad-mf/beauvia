<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with(['bookable', 'services', 'staffMember'])
            ->orderByDesc('booking_date')->paginate(10);

        $upcomingCount = $user->bookings()->upcoming()->whereIn('status', ['pending', 'confirmed'])->count();
        $completedCount = $user->bookings()->completed()->count();
        $totalSpent = $user->bookings()->completed()->sum('total_price');

        $favorites = $user->favorites()->with('favorable')->latest()->take(6)->get();

        return view('dashboard.customer.index', compact('bookings', 'upcomingCount', 'completedCount', 'totalSpent', 'favorites'));
    }

    public function bookings()
    {
        $bookings = auth()->user()->bookings()->with(['bookable', 'services', 'staffMember'])
            ->orderByDesc('booking_date')->paginate(15);

        return view('dashboard.customer.bookings', compact('bookings'));
    }

    public function cancelBooking(\App\Models\Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled', 'cancellation_reason' => 'Cancelled by customer']);
        return back()->with('success', 'Booking cancelled successfully.');
    }
}
