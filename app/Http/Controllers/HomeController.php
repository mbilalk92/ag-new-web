<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['images', 'category'])
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        $occasions = Occasion::orderBy('sort_order')->get();
        $bundles = Bundle::with('images')->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::current();

        // Until an admin sets a dedicated homepage banner, reuse the Virasat
        // collection's video so the homepage isn't left without a banner.
        $fallbackBannerVideoUrl = $settings->home_banner_has_video
            ? null
            : optional(Collection::where('slug', 'virasat')->first())->video_embed_url;

        return view('home', compact('products', 'categories', 'occasions', 'bundles', 'settings', 'fallbackBannerVideoUrl'));
    }
}
