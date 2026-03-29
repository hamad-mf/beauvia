<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::active()->with(['category', 'services', 'reviews']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating_avg', '>=', $request->rating);
        }

        $sort = $request->get('sort', 'recommended');
        $query = match ($sort) {
            'rating' => $query->orderByDesc('rating_avg'),
            'reviews' => $query->orderByDesc('rating_count'),
            'name' => $query->orderBy('name'),
            'price_low' => $query->orderBy(
                \App\Models\Service::selectRaw('MIN(price)')->whereColumn('serviceable_id', 'shops.id')->where('serviceable_type', Shop::class)->limit(1)
            ),
            'price_high' => $query->orderByDesc(
                \App\Models\Service::selectRaw('MIN(price)')->whereColumn('serviceable_id', 'shops.id')->where('serviceable_type', Shop::class)->limit(1)
            ),
            default => $query->orderByDesc('is_featured')->orderByDesc('rating_avg'),
        };

        $shops = $query->paginate(12);
        $categories = Category::active()->ordered()->get();

        return view('shops.index', compact('shops', 'categories'));
    }

    public function show(string $slug)
    {
        $shop = Shop::where('slug', $slug)->with([
            'category', 'services' => fn($q) => $q->active()->orderBy('sort_order'),
            'staffMembers' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'reviews.user', 'galleries', 'timeSlots',
        ])->firstOrFail();

        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = $shop->favorites()->where('user_id', auth()->id())->exists();
        }

        return view('shops.show', compact('shop', 'isFavorited'));
    }
}
