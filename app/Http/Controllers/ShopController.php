<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['images', 'category'])
            ->where('is_active', true);

        $activeCategoryModel = null;
        $activeOccasionModel = null;

        if ($categorySlug = $request->get('category')) {
            $activeCategoryModel = Category::where('slug', $categorySlug)->first();
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($occasionSlug = $request->get('occasion')) {
            $activeOccasionModel = Occasion::where('slug', $occasionSlug)->first();
            $query->whereHas('occasions', fn ($q) => $q->where('slug', $occasionSlug));
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $products = $query->get();
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        $occasions = Occasion::orderBy('sort_order')->get();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'occasions' => $occasions,
            'activeCategory' => $categorySlug,
            'activeCategoryModel' => $activeCategoryModel,
            'activeOccasion' => $occasionSlug,
            'activeOccasionModel' => $activeOccasionModel,
            'sort' => $sort,
        ]);
    }
}
