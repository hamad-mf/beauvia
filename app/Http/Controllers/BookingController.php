<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createShop(string $slug)
    {
        $shop = Shop::where('slug', $slug)->with([
            'services' => fn($q) => $q->active(),
            'staffMembers' => fn($q) => $q->where('is_active', true),
            'timeSlots',
        ])->firstOrFail();

        return view('bookings.create', [
            'provider' => $shop,
            'providerType' => 'shop',
            'services' => $shop->services,
            'staff' => $shop->staffMembers,
            'timeSlots' => $shop->timeSlots,
        ]);
    }

    public function createFreelancer(int $id)
    {
        $freelancer = FreelancerProfile::with([
            'user', 'services' => fn($q) => $q->active(), 'timeSlots',
        ])->findOrFail($id);

        return view('bookings.create', [
            'provider' => $freelancer,
            'providerType' => 'freelancer',
            'services' => $freelancer->services,
            'staff' => collect(),
            'timeSlots' => $freelancer->timeSlots,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_type' => 'required|in:shop,freelancer',
            'provider_id' => 'required|integer',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'staff_member_id' => 'nullable|integer',
            'notes' => 'nullable|string|max:500',
            'customer_address' => 'nullable|string|max:500',
            'customer_phone' => 'nullable|string|max:20',
        ]);

        $bookableType = $request->provider_type === 'shop' ? Shop::class : FreelancerProfile::class;
        $selectedServices = Service::whereIn('id', $request->services)->get();
        $totalPrice = $selectedServices->sum('price');
        $totalDuration = $selectedServices->sum('duration_minutes');

        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = $startTime->copy()->addMinutes($totalDuration);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'bookable_type' => $bookableType,
            'bookable_id' => $request->provider_id,
            'staff_member_id' => $request->staff_member_id,
            'booking_date' => $request->booking_date,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
            'customer_address' => $request->customer_address,
            'customer_phone' => $request->customer_phone,
        ]);

        foreach ($selectedServices as $svc) {
            $booking->services()->attach($svc->id, ['price' => $svc->price]);
        }

        return redirect()->route('bookings.confirmation', $booking)->with('success', 'Booking confirmed!');
    }

    public function confirmation(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['bookable', 'services', 'staffMember', 'user']);
        return view('bookings.confirmation', compact('booking'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'provider_type' => 'required|in:shop,freelancer',
            'provider_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;
        $providerType = $request->provider_type === 'shop' ? Shop::class : FreelancerProfile::class;

        $timeSlot = \App\Models\TimeSlot::where('slotable_type', $providerType)
            ->where('slotable_id', $request->provider_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$timeSlot) {
            return response()->json(['slots' => [], 'message' => 'Not available on this day']);
        }

        $existingBookings = Booking::where('bookable_type', $providerType)
            ->where('bookable_id', $request->provider_id)
            ->where('booking_date', $date->toDateString())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->get(['start_time', 'end_time']);

        $slots = [];
        $current = Carbon::createFromFormat('H:i', substr($timeSlot->open_time, 0, 5));
        $close = Carbon::createFromFormat('H:i', substr($timeSlot->close_time, 0, 5));

        while ($current->lt($close)) {
            $slotEnd = $current->copy()->addMinutes(30);
            $slotStr = $current->format('H:i');

            $isBooked = $existingBookings->contains(function ($b) use ($current, $slotEnd) {
                $bStart = Carbon::createFromFormat('H:i:s', $b->start_time);
                $bEnd = Carbon::createFromFormat('H:i:s', $b->end_time);
                return $current->lt($bEnd) && $slotEnd->gt($bStart);
            });

            $slots[] = [
                'time' => $slotStr,
                'display' => $current->format('g:i A'),
                'available' => !$isBooked,
            ];

            $current->addMinutes(30);
        }

        return response()->json(['slots' => $slots]);
    }
}
