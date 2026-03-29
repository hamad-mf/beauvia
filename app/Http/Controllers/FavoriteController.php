<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'favorable_type' => 'required|in:shop,freelancer',
            'favorable_id' => 'required|integer',
        ]);

        $type = $request->favorable_type === 'shop' ? Shop::class : FreelancerProfile::class;

        $existing = Favorite::where('user_id', auth()->id())
            ->where('favorable_type', $type)
            ->where('favorable_id', $request->favorable_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['favorited' => false, 'message' => 'Removed from favorites']);
        }

        Favorite::create([
            'user_id' => auth()->id(),
            'favorable_type' => $type,
            'favorable_id' => $request->favorable_id,
        ]);

        return response()->json(['favorited' => true, 'message' => 'Added to favorites']);
    }
}
