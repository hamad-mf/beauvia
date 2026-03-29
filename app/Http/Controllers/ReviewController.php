<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reviewable_type' => 'required|in:shop,freelancer',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $type = $request->reviewable_type === 'shop' ? Shop::class : FreelancerProfile::class;

        Review::create([
            'user_id' => auth()->id(),
            'reviewable_type' => $type,
            'reviewable_id' => $request->reviewable_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified' => false,
        ]);

        // Update rating
        $provider = $type::find($request->reviewable_id);
        if ($provider) {
            $provider->updateRating();
        }

        return back()->with('success', 'Review submitted successfully!');
    }
}
