<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;

class SitemapController extends Controller
{
    public function robots()
    {
        $settings = SiteSetting::current();

        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /cart',
            'Disallow: /checkout',
        ];

        if ($settings->robots_extra) {
            $lines[] = '';
            $lines[] = trim($settings->robots_extra);
        }

        $lines[] = '';
        $lines[] = 'Sitemap: ' . route('sitemap.xml');

        return response(implode("\n", $lines))->header('Content-Type', 'text/plain');
    }

    public function xml()
    {
        $urls = collect();

        $urls->push(['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily']);
        $urls->push(['loc' => route('shop.index'), 'priority' => '0.9', 'changefreq' => 'daily']);
        $urls->push(['loc' => route('bundle.index'), 'priority' => '0.8', 'changefreq' => 'weekly']);
        $urls->push(['loc' => route('client-diaries'), 'priority' => '0.6', 'changefreq' => 'weekly']);
        $urls->push(['loc' => route('contact.show'), 'priority' => '0.5', 'changefreq' => 'monthly']);
        $urls->push(['loc' => url('/sitemap'), 'priority' => '0.3', 'changefreq' => 'monthly']);

        foreach (Category::query()->get() as $category) {
            $urls->push([
                'loc' => route('shop.index', ['category' => $category->slug]),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ]);
        }

        foreach (Product::query()->where('is_active', true)->get() as $product) {
            $urls->push([
                'loc' => route('product.show', $product->slug),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $product->updated_at?->toAtomString(),
            ]);
        }

        foreach (Bundle::query()->where('is_active', true)->get() as $bundle) {
            $urls->push([
                'loc' => route('bundle.show', $bundle->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => $bundle->updated_at?->toAtomString(),
            ]);
        }

        return response()
            ->view('sitemap.xml', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }

    public function html()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $bundles = Bundle::where('is_active', true)->orderBy('name')->get();

        return view('sitemap.html', compact('categories', 'products', 'bundles'));
    }
}
