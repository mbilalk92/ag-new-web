<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewArrivalsSeeder extends Seeder
{
    public function run(): void
    {
        $sherwaniCategory = Category::where('slug', 'sherwani')->first();
        $barat = Occasion::where('slug', 'barat')->first();
        $nikkah = Occasion::where('slug', 'nikkah')->first();
        $valima = Occasion::where('slug', 'valima')->first();

        // 1. Replace the placeholder images on the existing "Ivory Nikkah
        // Sherwani" with the real photoshoot now that we have it.
        $ivoryNikkah = Product::where('slug', 'ivory-nikkah-sherwani')->first();

        if ($ivoryNikkah) {
            $ivoryNikkah->images()->delete();
            $ivoryNikkah->update(['video_file' => 'product-videos/reel-5.mp4']);

            $this->attachImages($ivoryNikkah, [
                'products/real/ivory-floral-sherwani-1.jpg',
                'products/real/ivory-floral-sherwani-2.jpg',
            ]);
        }

        // 2. New products surfaced by the client's fresh photoshoot.
        $newProducts = [
            [
                'name' => 'Champagne Hand-Embroidered Sherwani',
                'sku' => 'AG-0101',
                'price' => 45000,
                'description' => 'An heirloom-weight champagne sherwani, densely hand-embroidered edge to edge, paired here with a maroon silk shawl for the barat stage.',
                'fabric_details' => 'Raw silk base with dense hand embroidery (zardozi/dabka). Dry clean only.',
                'occasions' => array_filter([$barat, $nikkah]),
                'video' => 'product-videos/reel-4.mp4',
                'images' => [
                    'products/real/champagne-sherwani-1.jpg',
                    'products/real/champagne-sherwani-2.jpg',
                    'products/real/champagne-sherwani-3-editorial.jpg',
                    'products/real/champagne-sherwani-4-editorial.jpg',
                ],
            ],
            [
                'name' => 'Ivory Stone-Embroidered Sherwani',
                'sku' => 'AG-0102',
                'price' => 48000,
                'description' => 'A fully stone-embellished ivory sherwani with a fan-pleated turban finish — our most heavily embroidered piece, built for a nikkah or valima entrance.',
                'fabric_details' => 'Raw silk base, allover stone and crystal embroidery. Dry clean only.',
                'occasions' => array_filter([$nikkah, $valima]),
                'video' => 'product-videos/reel-7.mp4',
                'images' => [
                    'products/real/ivory-stone-sherwani-1.jpg',
                ],
            ],
            [
                'name' => 'Noir Hand-Embroidered Sherwani',
                'sku' => 'AG-0103',
                'price' => 46000,
                'description' => 'A black-on-black hand-embroidered sherwani for a groom who wants drama after sundown — styled here for both barat and valima.',
                'fabric_details' => 'Raw silk base, tonal hand embroidery with subtle sequin work. Dry clean only.',
                'occasions' => array_filter([$barat, $valima]),
                'video' => 'product-videos/reel-12.mp4',
                'images' => [
                    'products/real/noir-sherwani-1.jpg',
                    'products/real/noir-sherwani-2.jpg',
                    'products/real/noir-sherwani-3-editorial.jpg',
                ],
            ],
        ];

        foreach ($newProducts as $data) {
            if (Product::where('sku', $data['sku'])->exists()) {
                continue;
            }

            $product = Product::create([
                'category_id' => $sherwaniCategory->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'sku' => $data['sku'],
                'description' => $data['description'],
                'fabric_details' => $data['fabric_details'],
                'price' => $data['price'],
                'sizes' => ['38', '40', '42', '44', '46'],
                'stock' => rand(2, 8),
                'video_file' => $data['video'],
                'allow_custom_sizing' => true,
                'is_featured' => true,
                'is_active' => true,
            ]);

            $product->occasions()->attach(collect($data['occasions'])->pluck('id'));

            $this->attachImages($product, $data['images']);
        }
    }

    private function attachImages(Product $product, array $paths): void
    {
        foreach ($paths as $sort => $path) {
            $fullPath = Storage::disk('public')->path($path);
            [$width, $height] = @getimagesize($fullPath) ?: [1755, 2438];

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'width' => $width,
                'height' => $height,
                'sort_order' => $sort,
            ]);
        }
    }
}
