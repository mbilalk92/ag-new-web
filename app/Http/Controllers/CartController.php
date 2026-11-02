<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index', [
            'items' => Cart::items(),
            'subtotal' => Cart::subtotal(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:product,bundle',
            'item_id' => 'required|integer',
            'sizing_mode' => 'required|in:standard,custom',
            'size' => 'required_if:sizing_mode,standard|nullable|string',
            'measurements' => 'required_if:sizing_mode,custom|nullable|array',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $size = $data['sizing_mode'] === 'standard' ? ($data['size'] ?? null) : null;
        $measurements = $data['sizing_mode'] === 'custom' ? array_filter($data['measurements'] ?? []) : null;
        $quantity = $data['quantity'] ?? 1;

        if ($data['type'] === 'bundle') {
            $bundle = Bundle::with('images')->findOrFail($data['item_id']);
            Cart::addBundle($bundle, $size, $measurements, $quantity);
            $name = $bundle->name;
        } else {
            $product = Product::with('images')->findOrFail($data['item_id']);
            Cart::addProduct($product, $size, $measurements, $quantity);
            $name = $product->name;
        }

        if ($request->wantsJson()) {
            return response()->json(['count' => Cart::count()]);
        }

        return back()->with('status', $name . ' added to your cart.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:0',
        ]);

        Cart::update($data['key'], $data['quantity']);

        return back();
    }

    public function destroy(Request $request)
    {
        $data = $request->validate(['key' => 'required|string']);
        Cart::remove($data['key']);

        return back();
    }
}
