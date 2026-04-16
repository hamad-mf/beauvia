<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use League\Csv\Writer;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'bookable', 'services']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by provider type
        if ($request->filled('provider_type')) {
            $query->where('bookable_type', $request->provider_type === 'shop' ? Shop::class : FreelancerProfile::class);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }
        
        $bookings = $query->orderByDesc('booking_date')->paginate(25);
        
        $statusCounts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.bookings.index', compact('bookings', 'statusCounts'));
    }
    
    public function show(Booking $booking)
    {
        $booking->load(['user', 'bookable', 'services', 'staffMember']);
        return view('admin.bookings.show', compact('booking'));
    }
    
    public function cancel(Request $request, Booking $booking)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);
        
        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);
        
        ActivityLogger::log('booking_cancelled_by_admin', $booking, ['reason' => $request->cancellation_reason]);
        
        return back()->with('success', 'Booking cancelled.');
    }
    
    public function export(Request $request)
    {
        $query = Booking::with(['user', 'bookable', 'services']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }
        
        $bookings = $query->get();
        
        $csv = Writer::createFromString('');
        $csv->insertOne(['ID', 'Customer', 'Provider', 'Date', 'Time', 'Status', 'Total Price', 'Created At']);
        
        foreach ($bookings as $booking) {
            $providerName = $booking->bookable->name ?? $booking->bookable->user->name ?? 'N/A';
            $csv->insertOne([
                $booking->id,
                $booking->user->name,
                $providerName,
                $booking->booking_date,
                $booking->booking_time,
                $booking->status,
                $booking->total_price,
                $booking->created_at,
            ]);
        }
        
        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bookings-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
