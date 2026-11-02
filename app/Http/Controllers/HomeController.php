<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['images', 'category'])
            ->where('is_active', true)
            ->latest()
            ->get();

        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        $occasions = Occasion::orderBy('sort_order')->get();
        $bundles = Bundle::with('images')->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->get();

        return view('home', compact('products', 'categories', 'occasions', 'bundles'));
    }
}
