<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Nasibox',
                'slug' => 'nasibox',
                'description' => 'Paket nasi dengan pilihan menu yang beragam',
                'is_active' => true,
            ],
            [
                'name' => 'Catering Prasmanan',
                'slug' => 'catering-prasmanan',
                'description' => 'Paket catering untuk acara pernikahan dan hajatan',
                'is_active' => true,
            ],
            [
                'name' => 'Tumpengan',
                'slug' => 'tumpengan',
                'description' => 'Paket tumpengan tradisional untuk acara khusus',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
