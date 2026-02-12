<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Category Data from ProductSeeder
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
    }
}
