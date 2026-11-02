<?php

namespace App\Services;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Cart
{
    const SESSION_KEY = 'cart';

    public static function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public static function addProduct(Product $product, ?string $size, ?array $measurements, int $quantity = 1): void
    {
        $items = self::items();
        $sizeLabel = $measurements ? 'Custom fit' : $size;
        $key = $measurements
            ? 'product-' . $product->id . '-custom-' . Str::random(6)
            : 'product-' . $product->id . '-' . $size;

        if (! $measurements && isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $image = $product->images->first();

            $items[$key] = [
                'type' => 'product',
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->display_price,
                'size' => $sizeLabel,
                'measurements' => $measurements,
                'quantity' => $quantity,
                'image' => $image?->path,
            ];
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public static function addBundle(Bundle $bundle, ?string $size, ?array $measurements, int $quantity = 1): void
    {
        $items = self::items();
        $sizeLabel = $measurements ? 'Custom fit' : $size;
        $key = $measurements
            ? 'bundle-' . $bundle->id . '-custom-' . Str::random(6)
            : 'bundle-' . $bundle->id . '-' . $size;

        if (! $measurements && isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $image = $bundle->images->first();

            $items[$key] = [
                'type' => 'bundle',
                'id' => $bundle->id,
                'name' => $bundle->name,
                'slug' => $bundle->slug,
                'price' => $bundle->price,
                'size' => $sizeLabel,
                'measurements' => $measurements,
                'quantity' => $quantity,
                'image' => $image?->path,
            ];
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public static function update(string $key, int $quantity): void
    {
        $items = self::items();

        if (! isset($items[$key])) {
            return;
        }

        if ($quantity <= 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public static function remove(string $key): void
    {
        $items = self::items();
        unset($items[$key]);
        Session::put(self::SESSION_KEY, $items);
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function count(): int
    {
        return array_sum(array_column(self::items(), 'quantity'));
    }

    public static function subtotal(): int
    {
        return array_sum(array_map(
            fn ($item) => $item['price'] * $item['quantity'],
            self::items()
        ));
    }
}
