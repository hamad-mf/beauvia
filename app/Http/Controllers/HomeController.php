<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shop;
use App\Models\FreelancerProfile;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->get();
        $featuredShops = Shop::active()->featured()->with(['category', 'services'])->take(6)->get();
        $topFreelancers = FreelancerProfile::active()->featured()->with(['user', 'category', 'services'])->take(6)->get();
        $shopCount = Shop::active()->count();
        $freelancerCount = FreelancerProfile::active()->count();
        $reviewCount = \App\Models\Review::count();

        return view('home', compact('categories', 'featuredShops', 'topFreelancers', 'shopCount', 'freelancerCount', 'reviewCount'));
    }
}
