<?php

namespace App\Http\Controllers;

use App\Models\FreelancerProfile;
use App\Models\Category;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        $query = FreelancerProfile::active()->with(['user', 'category', 'services', 'reviews']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('bio', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('available')) {
            $query->available();
        }

        if ($request->filled('rating')) {
            $query->where('rating_avg', '>=', $request->rating);
        }

        $sort = $request->get('sort', 'recommended');
        $query = match ($sort) {
            'rating' => $query->orderByDesc('rating_avg'),
            'reviews' => $query->orderByDesc('rating_count'),
            'experience' => $query->orderByDesc('experience_years'),
            'price_low' => $query->orderBy('hourly_rate'),
            'price_high' => $query->orderByDesc('hourly_rate'),
            default => $query->orderByDesc('is_featured')->orderByDesc('rating_avg'),
        };

        $freelancers = $query->paginate(12);
        $categories = Category::active()->ordered()->get();

        return view('freelancers.index', compact('freelancers', 'categories'));
    }

    public function show(int $id)
    {
        $freelancer = FreelancerProfile::with([
            'user', 'category', 'services' => fn($q) => $q->active()->orderBy('sort_order'),
            'reviews.user', 'galleries', 'timeSlots',
        ])->findOrFail($id);

        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = $freelancer->favorites()->where('user_id', auth()->id())->exists();
        }

        return view('freelancers.show', compact('freelancer', 'isFavorited'));
    }
}
