<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FreelancerProfile;
use App\Models\Service;
use Illuminate\Http\Request;

class FreelancerDashController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->freelancerProfile;
        if (!$profile) return redirect()->route('freelancer.setup');

        $profile->load(['services', 'bookings' => fn($q) => $q->latest()->take(10), 'reviews' => fn($q) => $q->latest()->take(5)]);

        $todayBookings = $profile->bookings()->where('booking_date', today())->count();
        $pendingBookings = $profile->bookings()->pending()->count();
        $monthRevenue = $profile->bookings()->completed()
            ->whereMonth('booking_date', now()->month)->sum('total_price');

        return view('dashboard.freelancer.index', compact('profile', 'todayBookings', 'pendingBookings', 'monthRevenue'));
    }

    public function setup()
    {
        if (auth()->user()->freelancerProfile) return redirect()->route('freelancer.dashboard');
        $categories = \App\Models\Category::active()->ordered()->get();
        return view('dashboard.freelancer.setup', compact('categories'));
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'bio' => 'required|string',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'service_radius_km' => 'required|integer|min:1',
        ]);

        $profile = FreelancerProfile::create(array_merge($request->only([
            'category_id', 'title', 'bio', 'specialization', 'experience_years',
            'hourly_rate', 'service_radius_km',
        ]), ['user_id' => auth()->id(), 'is_mobile' => true]));

        for ($day = 1; $day <= 6; $day++) {
            $profile->timeSlots()->create([
                'day_of_week' => $day, 'open_time' => '09:00', 'close_time' => '18:00', 'is_available' => true,
            ]);
        }

        return redirect()->route('freelancer.dashboard')->with('success', 'Profile created!');
    }

    public function bookings()
    {
        $profile = auth()->user()->freelancerProfile;
        $bookings = $profile->bookings()->with(['user', 'services'])
            ->orderByDesc('booking_date')->paginate(15);

        return view('dashboard.freelancer.bookings', compact('bookings', 'profile'));
    }

    public function updateBookingStatus(Request $request, \App\Models\Booking $booking)
    {
        $profile = auth()->user()->freelancerProfile;
        if ($booking->bookable_type !== FreelancerProfile::class || $booking->bookable_id !== $profile->id) abort(403);

        $request->validate(['status' => 'required|in:confirmed,completed,cancelled,no_show']);
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated.');
    }

    public function services()
    {
        $profile = auth()->user()->freelancerProfile;
        $services = $profile->services()->orderBy('sort_order')->get();
        return view('dashboard.freelancer.services', compact('services', 'profile'));
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5',
            'description' => 'nullable|string',
        ]);

        $profile = auth()->user()->freelancerProfile;
        $profile->services()->create(array_merge($request->only(['name', 'price', 'duration_minutes', 'description']), [
            'category_id' => $profile->category_id,
        ]));

        return back()->with('success', 'Service added.');
    }

    public function deleteService(Service $service)
    {
        $profile = auth()->user()->freelancerProfile;
        if ($service->serviceable_type !== FreelancerProfile::class || $service->serviceable_id !== $profile->id) abort(403);
        $service->delete();
        return back()->with('success', 'Service removed.');
    }
}
