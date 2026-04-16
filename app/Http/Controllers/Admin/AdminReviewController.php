<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewDeletedMail;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'reviewable']);
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Filter by provider type
        if ($request->filled('provider_type')) {
            $query->where('reviewable_type', $request->provider_type === 'shop' ? Shop::class : FreelancerProfile::class);
        }
        
        // Filter flagged reviews
        if ($request->filled('flagged') && $request->flagged === '1') {
            $query->where('is_flagged', true);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }
        
        $reviews = $query->orderByDesc('created_at')->paginate(25);
        
        $flaggedCount = Review::where('is_flagged', true)->count();
        
        return view('admin.reviews.index', compact('reviews', 'flaggedCount'));
    }
    
    public function flag(Review $review)
    {
        $review->update(['is_flagged' => true]);
        
        ActivityLogger::log('review_flagged', $review);
        
        return back()->with('success', 'Review flagged.');
    }
    
    public function destroy(Review $review)
    {
        $reviewable = $review->reviewable;
        $review->delete();
        
        // Recalculate provider rating
        if ($reviewable) {
            $reviewable->updateRating();
        }
        
        ActivityLogger::log('review_deleted', $review);
        
        // Send email notification to review author
        if (config('mail.enabled', true)) {
            Mail::to($review->user->email)->send(new ReviewDeletedMail($review));
        }
        
        return back()->with('success', 'Review deleted and rating recalculated.');
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:flag,delete',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);
        
        $reviews = Review::whereIn('id', $request->review_ids)->get();
        $count = 0;
        
        foreach ($reviews as $review) {
            if ($request->action === 'flag') {
                $review->update(['is_flagged' => true]);
            } else {
                $reviewable = $review->reviewable;
                $review->delete();
                if ($reviewable) {
                    $reviewable->updateRating();
                }
                if (config('mail.enabled', true)) {
                    Mail::to($review->user->email)->send(new ReviewDeletedMail($review));
                }
            }
            $count++;
        }
        
        ActivityLogger::log("bulk_{$request->action}_reviews", null, ['count' => $count]);
        
        return back()->with('success', "{$count} reviews {$request->action}ed successfully.");
    }
}
