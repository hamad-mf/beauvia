<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreelancerProfile;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FreelancerApprovedMail;
use App\Mail\FreelancerRejectedMail;

class AdminFreelancerController extends Controller
{
    public function index(Request $request)
    {
        $query = FreelancerProfile::with(['user', 'category']);
        
        // Filter by approval status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }
        
        // Search by name, email, or city
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        }
        
        $freelancers = $query->withCount(['services', 'bookings', 'reviews'])
            ->orderByDesc('created_at')
            ->paginate(25);
        
        $statusCounts = [
            'all' => FreelancerProfile::count(),
            'pending' => FreelancerProfile::pending()->count(),
            'approved' => FreelancerProfile::approved()->count(),
            'rejected' => FreelancerProfile::rejected()->count(),
        ];
        
        return view('admin.freelancers.index', compact('freelancers', 'statusCounts'));
    }
    
    public function show(FreelancerProfile $freelancer)
    {
        $freelancer->load(['user', 'category', 'services', 'galleries', 'reviews.user', 'bookings' => fn($q) => $q->latest()->take(20)]);
        return view('admin.freelancers.show', compact('freelancer'));
    }
    
    public function approve(FreelancerProfile $freelancer)
    {
        $freelancer->update([
            'approval_status' => 'approved',
            'is_active' => true,
        ]);
        
        ActivityLogger::log('freelancer_approved', $freelancer);
        
        // Send email notification
        if (config('mail.enabled', true)) {
            Mail::to($freelancer->user->email)->send(new FreelancerApprovedMail($freelancer));
        }
        
        return back()->with('success', 'Freelancer approved successfully.');
    }
    
    public function reject(Request $request, FreelancerProfile $freelancer)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $freelancer->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'is_active' => false,
        ]);
        
        ActivityLogger::log('freelancer_rejected', $freelancer, ['reason' => $request->rejection_reason]);
        
        // Send email notification
        if (config('mail.enabled', true)) {
            Mail::to($freelancer->user->email)->send(new FreelancerRejectedMail($freelancer));
        }
        
        return back()->with('success', 'Freelancer rejected.');
    }
    
    public function suspend(FreelancerProfile $freelancer)
    {
        $freelancer->update(['is_active' => false]);
        
        ActivityLogger::log('freelancer_suspended', $freelancer);
        
        return back()->with('success', 'Freelancer suspended.');
    }
    
    public function reactivate(FreelancerProfile $freelancer)
    {
        $freelancer->update(['is_active' => true]);
        
        ActivityLogger::log('freelancer_reactivated', $freelancer);
        
        return back()->with('success', 'Freelancer reactivated.');
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,suspend',
            'freelancer_ids' => 'required|array',
            'freelancer_ids.*' => 'exists:freelancer_profiles,id',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);
        
        $freelancers = FreelancerProfile::whereIn('id', $request->freelancer_ids)->get();
        $count = 0;
        
        foreach ($freelancers as $freelancer) {
            switch ($request->action) {
                case 'approve':
                    $freelancer->update(['approval_status' => 'approved', 'is_active' => true]);
                    if (config('mail.enabled', true)) {
                        Mail::to($freelancer->user->email)->send(new FreelancerApprovedMail($freelancer));
                    }
                    break;
                case 'reject':
                    $freelancer->update([
                        'approval_status' => 'rejected',
                        'rejection_reason' => $request->rejection_reason,
                        'is_active' => false,
                    ]);
                    if (config('mail.enabled', true)) {
                        Mail::to($freelancer->user->email)->send(new FreelancerRejectedMail($freelancer));
                    }
                    break;
                case 'suspend':
                    $freelancer->update(['is_active' => false]);
                    break;
            }
            $count++;
        }
        
        ActivityLogger::log("bulk_{$request->action}_freelancers", null, ['count' => $count]);
        
        return back()->with('success', "{$count} freelancers {$request->action}ed successfully.");
    }
}
