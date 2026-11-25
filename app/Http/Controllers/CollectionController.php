<?php

namespace App\Http\Controllers;

use App\Models\Collection;

class CollectionController extends Controller
{
    public function show(string $slug)
    {
        $collection = Collection::query()
            ->with(['products.images', 'products.category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('collection.show', compact('collection'));
    }
}
