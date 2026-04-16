<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShopApprovedMail;
use App\Mail\ShopRejectedMail;

class AdminShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::with(['user', 'category']);
        
        // Filter by approval status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }
        
        // Search by name, owner name, or city
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $shops = $query->withCount(['services', 'bookings', 'reviews'])
            ->orderByDesc('created_at')
            ->paginate(25);
        
        $statusCounts = [
            'all' => Shop::count(),
            'pending' => Shop::pending()->count(),
            'approved' => Shop::approved()->count(),
            'rejected' => Shop::rejected()->count(),
        ];
        
        return view('admin.shops.index', compact('shops', 'statusCounts'));
    }
    
    public function show(Shop $shop)
    {
        $shop->load(['user', 'category', 'services', 'galleries', 'reviews.user', 'bookings' => fn($q) => $q->latest()->take(20)]);
        return view('admin.shops.show', compact('shop'));
    }
    
    public function approve(Shop $shop)
    {
        $shop->update([
            'approval_status' => 'approved',
            'is_active' => true,
        ]);
        
        ActivityLogger::log('shop_approved', $shop);
        
        // Send email notification
        if (config('mail.enabled', true)) {
            Mail::to($shop->user->email)->send(new ShopApprovedMail($shop));
        }
        
        return back()->with('success', 'Shop approved successfully.');
    }
    
    public function reject(Request $request, Shop $shop)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $shop->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'is_active' => false,
        ]);
        
        ActivityLogger::log('shop_rejected', $shop, ['reason' => $request->rejection_reason]);
        
        // Send email notification
        if (config('mail.enabled', true)) {
            Mail::to($shop->user->email)->send(new ShopRejectedMail($shop));
        }
        
        return back()->with('success', 'Shop rejected.');
    }
    
    public function suspend(Shop $shop)
    {
        $shop->update(['is_active' => false]);
        
        ActivityLogger::log('shop_suspended', $shop);
        
        return back()->with('success', 'Shop suspended.');
    }
    
    public function reactivate(Shop $shop)
    {
        $shop->update(['is_active' => true]);
        
        ActivityLogger::log('shop_reactivated', $shop);
        
        return back()->with('success', 'Shop reactivated.');
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,suspend',
            'shop_ids' => 'required|array',
            'shop_ids.*' => 'exists:shops,id',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);
        
        $shops = Shop::whereIn('id', $request->shop_ids)->get();
        $count = 0;
        
        foreach ($shops as $shop) {
            switch ($request->action) {
                case 'approve':
                    $shop->update(['approval_status' => 'approved', 'is_active' => true]);
                    if (config('mail.enabled', true)) {
                        Mail::to($shop->user->email)->send(new ShopApprovedMail($shop));
                    }
                    break;
                case 'reject':
                    $shop->update([
                        'approval_status' => 'rejected',
                        'rejection_reason' => $request->rejection_reason,
                        'is_active' => false,
                    ]);
                    if (config('mail.enabled', true)) {
                        Mail::to($shop->user->email)->send(new ShopRejectedMail($shop));
                    }
                    break;
                case 'suspend':
                    $shop->update(['is_active' => false]);
                    break;
            }
            $count++;
        }
        
        ActivityLogger::log("bulk_{$request->action}_shops", null, ['count' => $count]);
        
        return back()->with('success', "{$count} shops {$request->action}ed successfully.");
    }
}
