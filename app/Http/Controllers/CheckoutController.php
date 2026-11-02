<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    const SHIPPING_FEE = 300;

    public function show()
    {
        $items = Cart::items();

        if (empty($items)) {
            return redirect()->route('shop.cart')->with('status', 'Your cart is empty.');
        }

        return view('checkout.show', [
            'items' => $items,
            'subtotal' => Cart::subtotal(),
            'shipping' => self::SHIPPING_FEE,
        ]);
    }

    public function store(Request $request)
    {
        $items = Cart::items();

        if (empty($items)) {
            return redirect()->route('shop.cart');
        }

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:120',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer',
            'payment_proof' => 'required_if:payment_method,bank_transfer|nullable|image|max:4096',
        ]);

        $subtotal = Cart::subtotal();
        $shipping = self::SHIPPING_FEE;

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $data['customer_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'notes' => $data['notes'] ?? null,
            'payment_method' => $data['payment_method'],
            'payment_proof' => $proofPath,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping,
            'total' => $subtotal + $shipping,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_type' => $item['type'],
                'product_id' => $item['type'] === 'product' ? $item['id'] : null,
                'bundle_id' => $item['type'] === 'bundle' ? $item['id'] : null,
                'product_name' => $item['name'],
                'size' => $item['size'],
                'measurements' => $item['measurements'] ?? null,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        Cart::clear();

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
