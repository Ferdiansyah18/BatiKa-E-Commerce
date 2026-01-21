<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure categories exist
        $cats = [
            ['name' => 'Handbags', 'icon' => 'bi-handbag'],
            ['name' => 'Tote Bags', 'icon' => 'bi-bag'],
            ['name' => 'Sling Bags', 'icon' => 'bi-bag-heart'],
            ['name' => 'Travel Bags', 'icon' => 'bi-briefcase'],
        ];

        foreach ($cats as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'icon' => $cat['icon']]
            );
        }

        $categories = Category::all();

        // 10 Dummy Products
        $products = [
            [
                'name' => 'Parang Rusak Heritage Tote',
                'price' => 1250000,
                'description' => 'A classic tote bag featuring the royal Parang Rusak motif, symbolizing power and strength. Made from premium cotton canvas with genuine leather straps.',
                'image' => 'products/bag1.png', // Tote
                'category' => 'Tote Bags',
            ],
            [
                'name' => 'Kawung Elegant Handbag',
                'price' => 1850000,
                'description' => 'Sophisticated handbag with the Kawung pattern, representing purity and honesty. Perfect for formal occasions.',
                'image' => 'products/bag2.png', // Handbag
                'category' => 'Handbags',
            ],
            [
                'name' => 'Mega Mendung Blue Sling',
                'price' => 850000,
                'description' => 'Modern sling bag with the vivid Mega Mendung cloud pattern from Cirebon. Compact yet spacious for daily essentials.',
                'image' => 'products/bag3.png', // Sling
                'category' => 'Sling Bags',
            ],
            [
                'name' => 'Sogan Classic Shopper',
                'price' => 950000,
                'description' => 'Spacious shopper bag in traditional Sogan (brown) colors. Durable and stylish for everyday use.',
                'image' => 'products/bag1.png',
                'category' => 'Tote Bags',
            ],
            [
                'name' => 'Truntum Love Satchel',
                'price' => 2100000,
                'description' => 'A romantic satchel bag featuring the Truntum motif, often gifted by parents to children at weddings. High-quality leather finish.',
                'image' => 'products/bag2.png',
                'category' => 'Handbags',
            ],
            [
                'name' => 'Sekar Jagad Traveler',
                'price' => 2500000,
                'description' => 'Large travel duffel with Sekar Jagad pattern, celebrating the diversity of the world. Water-resistant lining.',
                'image' => 'products/bag1.png', // Reusing Tote image as placeholder for travel
                'category' => 'Travel Bags',
            ],
            [
                'name' => 'Pekalongan Floral Crossbody',
                'price' => 750000,
                'description' => 'Cheerfull floral patterns typical of Pekalongan batik. Lightweight and fun for weekends.',
                'image' => 'products/bag3.png',
                'category' => 'Sling Bags',
            ],
            [
                'name' => 'Lasem Red Clutch',
                'price' => 650000,
                'description' => 'Bold red clutch with Chinese-influenced Lasem batik patterns. A statement piece for evening wear.',
                'image' => 'products/bag2.png',
                'category' => 'Handbags',
            ],
            [
                'name' => 'Gentongan Madura Tote',
                'price' => 1100000,
                'description' => 'Unique abstract patterns from Madura. The fabric is dip-dyed in clay vats (gentong) for deep, lasting colors.',
                'image' => 'products/bag1.png',
                'category' => 'Tote Bags',
            ],
            [
                'name' => 'Garutan Pastel Shoulder Bag',
                'price' => 890000,
                'description' => 'Soft pastel colors from Garut. feminine and chic, perfect for brunch or casual outings.',
                'image' => 'products/bag3.png',
                'category' => 'Sling Bags',
            ],
        ];

        foreach ($products as $p) {
            $cat = $categories->where('name', $p['category'])->first();
            
            Product::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'category_id' => $cat->id,
                'price' => $p['price'],
                'thumbnail' => $p['image'], // Path relative to storage/app/public/
                'description' => $p['description'],
                'specifications' => [
                    'material' => 'Cotton Batik & Leather',
                    'dimensions' => '30x25x10 cm',
                    'weight' => '0.5 kg'
                ],
                'discount_price' => rand(0, 1) ? $p['price'] * 0.9 : null, // 50% chance of discount
                'discount_start_date' => now(),
                'discount_end_date' => now()->addMonth(),
            ]);
        }
    }
}
