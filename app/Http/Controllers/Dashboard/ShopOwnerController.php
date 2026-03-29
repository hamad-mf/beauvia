<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopOwnerController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;
        if (!$shop) return redirect()->route('shop.setup');

        $shop->load(['services', 'staffMembers', 'bookings' => fn($q) => $q->latest()->take(10), 'reviews' => fn($q) => $q->latest()->take(5)]);

        $todayBookings = $shop->bookings()->where('booking_date', today())->count();
        $pendingBookings = $shop->bookings()->pending()->count();
        $monthRevenue = $shop->bookings()->completed()
            ->whereMonth('booking_date', now()->month)->sum('total_price');
        $totalReviews = $shop->rating_count;

        return view('dashboard.shop.index', compact('shop', 'todayBookings', 'pendingBookings', 'monthRevenue', 'totalReviews'));
    }

    public function setup()
    {
        if (auth()->user()->shop) return redirect()->route('shop.dashboard');
        $categories = \App\Models\Category::active()->ordered()->get();
        return view('dashboard.shop.setup', compact('categories'));
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $shop = Shop::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . rand(100, 999),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        // Default time slots
        for ($day = 1; $day <= 6; $day++) {
            $shop->timeSlots()->create([
                'day_of_week' => $day, 'open_time' => '09:00', 'close_time' => '18:00', 'is_available' => true,
            ]);
        }

        return redirect()->route('shop.dashboard')->with('success', 'Shop created successfully!');
    }

    public function bookings()
    {
        $shop = auth()->user()->shop;
        $bookings = $shop->bookings()->with(['user', 'services', 'staffMember'])
            ->orderByDesc('booking_date')->paginate(15);

        return view('dashboard.shop.bookings', compact('bookings', 'shop'));
    }

    public function updateBookingStatus(Request $request, \App\Models\Booking $booking)
    {
        $shop = auth()->user()->shop;
        if ($booking->bookable_type !== Shop::class || $booking->bookable_id !== $shop->id) abort(403);

        $request->validate(['status' => 'required|in:confirmed,completed,cancelled,no_show']);
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated.');
    }

    public function services()
    {
        $shop = auth()->user()->shop;
        $services = $shop->services()->orderBy('sort_order')->get();
        return view('dashboard.shop.services', compact('services', 'shop'));
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5',
            'description' => 'nullable|string',
        ]);

        $shop = auth()->user()->shop;
        $shop->services()->create(array_merge($request->only(['name', 'price', 'duration_minutes', 'description']), [
            'category_id' => $shop->category_id,
        ]));

        return back()->with('success', 'Service added.');
    }

    public function deleteService(Service $service)
    {
        $shop = auth()->user()->shop;
        if ($service->serviceable_type !== Shop::class || $service->serviceable_id !== $shop->id) abort(403);
        $service->delete();
        return back()->with('success', 'Service removed.');
    }
}
