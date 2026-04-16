<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'commission_rate' => Setting::get('commission_rate', 10),
            'allow_new_providers' => Setting::get('allow_new_providers', 1),
            'allow_bookings' => Setting::get('allow_bookings', 1),
            'cancellation_hours' => Setting::get('cancellation_hours', 24),
            'min_booking_advance_hours' => Setting::get('min_booking_advance_hours', 2),
            'max_booking_advance_days' => Setting::get('max_booking_advance_days', 90),
            'email_notifications_enabled' => Setting::get('email_notifications_enabled', 1),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
            'allow_new_providers' => 'required|boolean',
            'allow_bookings' => 'required|boolean',
            'cancellation_hours' => 'required|integer|min:0',
            'min_booking_advance_hours' => 'required|integer|min:0',
            'max_booking_advance_days' => 'required|integer|min:1',
            'email_notifications_enabled' => 'required|boolean',
        ]);
        
        foreach ($request->only([
            'commission_rate', 'allow_new_providers', 'allow_bookings', 
            'cancellation_hours', 'min_booking_advance_hours', 
            'max_booking_advance_days', 'email_notifications_enabled'
        ]) as $key => $value) {
            Setting::set($key, $value);
        }
        
        ActivityLogger::log('settings_updated', null, ['settings' => $request->all()]);
        
        return back()->with('success', 'Settings updated successfully.');
    }
}
