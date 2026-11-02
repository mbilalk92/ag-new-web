<?php

namespace App\Http\Controllers;

use App\Models\Bundle;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::query()
            ->with('images')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('bundle.index', compact('bundles'));
    }

    public function show(string $slug)
    {
        $bundle = Bundle::query()
            ->with('images')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('bundle.show', compact('bundle'));
    }
}
