<?php

namespace Database\Seeders;

use App\Models\Bundle;
use App\Models\BundleImage;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [];
        $catDefs = [
            ['Sherwani', 'top'],
            ['Kurta', 'top'],
            ['Waist Coat', 'top'],
            ['Prince Coat', 'top'],
            ['Tuxedo', 'top_trouser'],
            ['Blazer', 'top'],
            ['Three Piece Suit', 'top_trouser'],
            ['Turban', 'none'],
            ['Shawl', 'none'],
            ['Khussa', 'none'],
            ['Shoes', 'none'],
            ['Sandals', 'none'],
            ['Moccasins', 'none'],
        ];

        foreach ($catDefs as $i => [$name, $measurementType]) {
            $categories[$name] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'measurement_type' => $measurementType,
                'sort_order' => $i,
            ]);
        }

        $occasions = [];
        foreach (['Barat', 'Nikkah', 'Valima', 'Mehndi', 'Engagement'] as $i => $name) {
            $occasions[$name] = Occasion::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'sort_order' => $i,
            ]);
        }

        $products = [
            [
                'name' => 'Black Elegance Sherwani',
                'category' => 'Sherwani',
                'occasions' => ['Barat', 'Nikkah'],
                'price' => 40000,
                'sizes' => ['38', '40', '42', '44', '46'],
                'custom_sizing' => true,
                'description' => 'A richly hand-embroidered black sherwani, cut for a commanding silhouette on the barat stage. Finished with tone-on-tone threadwork across the collar and placket.',
                'fabric_details' => 'Raw silk base with hand-embroidered zari and dabka work. Dry clean only.',
                'featured' => true,
                'images' => ['products/real/black-elegance-1.jpg', 'products/real/black-elegance-2.jpg'],
            ],
            [
                'name' => 'Off-White Hand-Embroidered Sherwani',
                'category' => 'Sherwani',
                'occasions' => ['Valima', 'Nikkah'],
                'price' => 40000,
                'sizes' => ['38', '40', '42', '44'],
                'custom_sizing' => true,
                'description' => 'An ivory sherwani with delicate hand embroidery, suited to a daytime nikkah or valima look. Pairs well with a gold or ivory turban.',
                'fabric_details' => 'Jacquard base fabric, hand-embroidered yoke. Dry clean only.',
                'featured' => true,
                'images' => ['products/real/offwhite-sherwani-1.jpg'],
            ],
            [
                'name' => 'Ivory Nikkah Sherwani',
                'category' => 'Sherwani',
                'occasions' => ['Nikkah'],
                'price' => 42000,
                'sizes' => ['38', '40', '42', '44', '46'],
                'custom_sizing' => true,
                'description' => 'Clean-lined ivory sherwani for the nikkah ceremony, with understated gold piping at the collar.',
                'fabric_details' => 'Raw silk, gold piping detail. Dry clean only.',
                'featured' => true,
                'images' => ['products/placeholders/ivory-nikkah-sherwani-1.jpg', 'products/placeholders/ivory-nikkah-sherwani-2.jpg'],
            ],
            [
                'name' => 'Maroon Zari Kurta',
                'category' => 'Kurta',
                'occasions' => ['Mehndi'],
                'price' => 12500,
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'custom_sizing' => true,
                'description' => 'A deep maroon kurta with gold zari borders, built for the mehndi night.',
                'fabric_details' => 'Cotton silk blend. Machine wash cold, line dry.',
                'featured' => true,
                'images' => ['products/placeholders/maroon-zari-kurta-1.jpg', 'products/placeholders/maroon-zari-kurta-2.jpg'],
            ],
            [
                'name' => 'Rust Mehndi Kurta',
                'category' => 'Kurta',
                'occasions' => ['Mehndi', 'Engagement'],
                'price' => 11000,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'custom_sizing' => true,
                'description' => 'Rust-toned kurta with subtle thread detailing at the cuffs, a warmer alternative for mehndi functions.',
                'fabric_details' => 'Cotton silk blend.',
                'featured' => false,
                'images' => ['products/placeholders/rust-mehndi-kurta-1.jpg', 'products/placeholders/rust-mehndi-kurta-2.jpg'],
            ],
            [
                'name' => 'Ivory Brocade Waistcoat',
                'category' => 'Waist Coat',
                'occasions' => ['Nikkah', 'Engagement'],
                'price' => 9500,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'custom_sizing' => true,
                'description' => 'Ivory brocade waistcoat with a fitted cut, layered over a kurta or shirt for nikkah and engagement functions.',
                'fabric_details' => 'Jacquard brocade, satin lining.',
                'featured' => false,
                'images' => ['products/placeholders/ivory-brocade-waistcoat-1.jpg', 'products/placeholders/ivory-brocade-waistcoat-2.jpg'],
            ],
            [
                'name' => 'Bottle Green Waistcoat',
                'category' => 'Waist Coat',
                'occasions' => ['Engagement'],
                'price' => 9800,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'custom_sizing' => true,
                'description' => 'Bottle green waistcoat with brass-tone buttons, a versatile layer for engagement and reception looks.',
                'fabric_details' => 'Velvet-finish brocade, satin lining.',
                'featured' => false,
                'images' => ['products/placeholders/bottle-green-waistcoat-1.jpg', 'products/placeholders/bottle-green-waistcoat-2.jpg'],
            ],
            [
                'name' => 'Emerald Prince Coat',
                'category' => 'Prince Coat',
                'occasions' => ['Barat'],
                'price' => 28000,
                'sizes' => ['38', '40', '42', '44'],
                'custom_sizing' => true,
                'description' => 'Emerald prince coat with a Nehru collar and gold button detailing, for a barat look with a modern edge.',
                'fabric_details' => 'Raw silk, structured shoulder.',
                'featured' => true,
                'images' => ['products/placeholders/emerald-prince-coat-1.jpg', 'products/placeholders/emerald-prince-coat-2.jpg'],
            ],
            [
                'name' => 'Charcoal Tuxedo',
                'category' => 'Tuxedo',
                'occasions' => ['Valima'],
                'price' => 32000,
                'sizes' => ['38', '40', '42', '44', '46'],
                'custom_sizing' => true,
                'description' => 'Classic charcoal tuxedo with satin lapel, for a valima reception or walima dinner.',
                'fabric_details' => 'Wool-blend suiting, satin lapel facing.',
                'featured' => false,
                'images' => ['products/placeholders/charcoal-tuxedo-1.jpg', 'products/placeholders/charcoal-tuxedo-2.jpg'],
            ],
            [
                'name' => 'Engagement Blazer',
                'category' => 'Blazer',
                'occasions' => ['Engagement'],
                'price' => 18500,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'custom_sizing' => true,
                'description' => 'Tailored navy blazer with subtle texture, suited to engagement functions and daytime events.',
                'fabric_details' => 'Wool-blend suiting.',
                'featured' => false,
                'images' => ['products/placeholders/engagement-blazer-1.jpg', 'products/placeholders/engagement-blazer-2.jpg'],
            ],
            [
                'name' => 'Classic Two-Piece Suit',
                'category' => 'Three Piece Suit',
                'occasions' => ['Valima', 'Engagement'],
                'price' => 26000,
                'sizes' => ['38', '40', '42', '44'],
                'custom_sizing' => true,
                'description' => 'A clean two-piece suit for the groom who wants a sharp, understated look at the reception.',
                'fabric_details' => 'Wool-blend suiting.',
                'featured' => false,
                'images' => ['products/placeholders/classic-two-piece-suit-1.jpg', 'products/placeholders/classic-two-piece-suit-2.jpg'],
            ],
            [
                'name' => 'Burgundy Three-Piece Suit',
                'category' => 'Three Piece Suit',
                'occasions' => ['Valima'],
                'price' => 31000,
                'sizes' => ['38', '40', '42', '44', '46'],
                'custom_sizing' => true,
                'description' => 'Burgundy three-piece suit with matching waistcoat, a rich alternative to classic black-tie.',
                'fabric_details' => 'Wool-blend suiting, matching waistcoat included.',
                'featured' => true,
                'images' => ['products/placeholders/burgundy-three-piece-suit-1.jpg', 'products/placeholders/burgundy-three-piece-suit-2.jpg'],
            ],
            [
                'name' => 'Gold Threadwork Turban',
                'category' => 'Turban',
                'occasions' => ['Barat', 'Nikkah'],
                'price' => 6500,
                'sizes' => ['One Size'],
                'custom_sizing' => false,
                'description' => 'Pre-tied gold threadwork turban (safa), finished with a decorative kalgi pin.',
                'fabric_details' => 'Silk base with gold zari border.',
                'featured' => false,
                'images' => ['products/placeholders/gold-threadwork-turban-1.jpg', 'products/placeholders/gold-threadwork-turban-2.jpg'],
            ],
            [
                'name' => 'Embroidered Khussa',
                'category' => 'Khussa',
                'occasions' => ['Barat', 'Mehndi'],
                'price' => 7500,
                'sizes' => ['40', '41', '42', '43', '44'],
                'custom_sizing' => false,
                'description' => 'Hand-embroidered khussa with a cushioned sole, for the barat and mehndi functions.',
                'fabric_details' => 'Leather sole, hand-embroidered upper.',
                'featured' => false,
                'images' => ['products/placeholders/embroidered-khussa-1.jpg', 'products/placeholders/embroidered-khussa-2.jpg'],
            ],
            [
                'name' => 'Formal Oxford Shoe',
                'category' => 'Shoes',
                'occasions' => ['Valima', 'Engagement'],
                'price' => 8500,
                'sizes' => ['40', '41', '42', '43', '44'],
                'custom_sizing' => false,
                'description' => 'Polished black oxford shoe for the reception and other formal functions.',
                'fabric_details' => 'Genuine leather upper and sole.',
                'featured' => false,
                'images' => ['products/placeholders/formal-oxford-shoe-1.jpg', 'products/placeholders/formal-oxford-shoe-2.jpg'],
            ],
            [
                'name' => 'Strap Wedding Sandal',
                'category' => 'Sandals',
                'occasions' => ['Mehndi', 'Valima'],
                'price' => 6800,
                'sizes' => ['40', '41', '42', '43', '44'],
                'custom_sizing' => false,
                'description' => 'An open strap sandal with a gold-tone buckle, suited to a mehndi or daytime function.',
                'fabric_details' => 'Leather straps, cushioned footbed.',
                'featured' => false,
                'images' => ['products/placeholders/strap-wedding-sandal-1.jpg', 'products/placeholders/strap-wedding-sandal-2.jpg'],
            ],
            [
                'name' => 'Suede Moccasin',
                'category' => 'Moccasins',
                'occasions' => ['Engagement', 'Valima'],
                'price' => 7200,
                'sizes' => ['40', '41', '42', '43', '44'],
                'custom_sizing' => false,
                'description' => 'A soft suede moccasin for a relaxed, smart-casual finish at engagement and daytime events.',
                'fabric_details' => 'Suede upper, flexible rubber sole.',
                'featured' => false,
                'images' => ['products/placeholders/suede-moccasin-1.jpg', 'products/placeholders/suede-moccasin-2.jpg'],
            ],
            [
                'name' => 'Silk Pocket Shawl',
                'category' => 'Shawl',
                'occasions' => ['Barat', 'Nikkah'],
                'price' => 5500,
                'sizes' => ['One Size'],
                'custom_sizing' => false,
                'description' => 'A silk pocket shawl to drape over the shoulder of a sherwani or prince coat.',
                'fabric_details' => '100% silk.',
                'featured' => false,
                'images' => ['products/placeholders/silk-pocket-shawl-1.jpg', 'products/placeholders/silk-pocket-shawl-2.jpg'],
            ],
        ];

        foreach ($products as $index => $data) {
            $product = Product::create([
                'category_id' => $categories[$data['category']]->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'sku' => 'AG-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'description' => $data['description'],
                'fabric_details' => $data['fabric_details'],
                'price' => $data['price'],
                'sizes' => $data['sizes'],
                'stock' => rand(2, 12),
                'allow_custom_sizing' => $data['custom_sizing'],
                'is_featured' => $data['featured'],
                'is_active' => true,
            ]);

            $product->occasions()->attach(array_map(fn ($name) => $occasions[$name]->id, $data['occasions']));

            foreach ($data['images'] as $sort => $path) {
                $fullPath = Storage::disk('public')->path($path);
                [$width, $height] = @getimagesize($fullPath) ?: [900, 1150];

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'width' => $width,
                    'height' => $height,
                    'sort_order' => $sort,
                ]);
            }
        }

        $bundles = [
            [
                'name' => 'Full Wedding Tailored Bundle',
                'description' => 'Everything for the big day in one order: a hand-embroidered sherwani, matching waistcoat, turban, and khussa — tailored as a set so the tones and embroidery line up.',
                'included_items' => [
                    ['label' => 'Sherwani', 'description' => 'Hand-embroidered, your choice of black or ivory'],
                    ['label' => 'Waistcoat', 'description' => 'Matching brocade waistcoat'],
                    ['label' => 'Turban', 'description' => 'Pre-tied gold threadwork safa'],
                    ['label' => 'Khussa', 'description' => 'Hand-embroidered khussa'],
                ],
                'price' => 85000,
                'compare_at_price' => 112500,
                'measurement_type' => 'top',
                'sizes' => ['38', '40', '42', '44', '46'],
                'featured' => true,
                'images' => ['bundles/placeholders/full-wedding-tailored-bundle-1.jpg', 'bundles/placeholders/full-wedding-tailored-bundle-2.jpg'],
            ],
            [
                'name' => 'Nikkah Bundle',
                'description' => 'An ivory sherwani and waistcoat pairing finished with khussa, built for the nikkah ceremony.',
                'included_items' => [
                    ['label' => 'Sherwani', 'description' => 'Ivory hand-embroidered'],
                    ['label' => 'Waistcoat', 'description' => 'Ivory brocade'],
                    ['label' => 'Khussa', 'description' => 'Hand-embroidered khussa'],
                ],
                'price' => 55000,
                'compare_at_price' => 68500,
                'measurement_type' => 'top',
                'sizes' => ['38', '40', '42', '44'],
                'featured' => true,
                'images' => ['bundles/placeholders/nikkah-bundle-1.jpg', 'bundles/placeholders/nikkah-bundle-2.jpg'],
            ],
            [
                'name' => 'Mehndi Bundle',
                'description' => 'A maroon kurta and waistcoat pairing with khussa, ready for the mehndi night.',
                'included_items' => [
                    ['label' => 'Kurta', 'description' => 'Maroon zari-embroidered'],
                    ['label' => 'Waistcoat', 'description' => 'Bottle green brocade'],
                    ['label' => 'Khussa', 'description' => 'Hand-embroidered khussa'],
                ],
                'price' => 28000,
                'compare_at_price' => 34300,
                'measurement_type' => 'top',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'featured' => true,
                'images' => ['bundles/placeholders/mehndi-bundle-1.jpg', 'bundles/placeholders/mehndi-bundle-2.jpg'],
            ],
            [
                'name' => 'Valima Bundle',
                'description' => 'A three-piece suit and formal oxford shoes, tailored together for a sharp valima reception look.',
                'included_items' => [
                    ['label' => 'Three-piece suit', 'description' => 'Burgundy, with matching waistcoat'],
                    ['label' => 'Formal shoes', 'description' => 'Black oxford'],
                ],
                'price' => 48000,
                'compare_at_price' => 58500,
                'measurement_type' => 'top_trouser',
                'sizes' => ['38', '40', '42', '44', '46'],
                'featured' => false,
                'images' => ['bundles/placeholders/valima-bundle-1.jpg', 'bundles/placeholders/valima-bundle-2.jpg'],
            ],
            [
                'name' => 'Engagement Bundle',
                'description' => 'A tailored blazer and waistcoat finished with moccasins, for a relaxed but sharp engagement look.',
                'included_items' => [
                    ['label' => 'Blazer', 'description' => 'Navy textured'],
                    ['label' => 'Waistcoat', 'description' => 'Bottle green brocade'],
                    ['label' => 'Moccasins', 'description' => 'Suede'],
                ],
                'price' => 32000,
                'compare_at_price' => 38200,
                'measurement_type' => 'top',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'featured' => false,
                'images' => ['bundles/placeholders/engagement-bundle-1.jpg', 'bundles/placeholders/engagement-bundle-2.jpg'],
            ],
        ];

        foreach ($bundles as $data) {
            $bundle = Bundle::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'included_items' => $data['included_items'],
                'sizes' => $data['sizes'],
                'measurement_type' => $data['measurement_type'],
                'price' => $data['price'],
                'compare_at_price' => $data['compare_at_price'],
                'is_featured' => $data['featured'],
                'is_active' => true,
            ]);

            foreach ($data['images'] as $sort => $path) {
                $fullPath = Storage::disk('public')->path($path);
                [$width, $height] = @getimagesize($fullPath) ?: [1000, 1250];

                BundleImage::create([
                    'bundle_id' => $bundle->id,
                    'path' => $path,
                    'width' => $width,
                    'height' => $height,
                    'sort_order' => $sort,
                ]);
            }
        }
    }
}
