<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Nasibox Products
        $nasiboxCategory = Category::where('slug', 'nasibox')->first();

        $nasiboxProducts = [
            [
                'name' => 'Nasibox Ayam Bakar',
                'slug' => 'nasibox-ayam-bakar',
                'description' => 'Paket nasibox berisi nasi putih, ayam bakar, sambal matah, dan lalapan segar',
                'price' => 35000,
                'stock' => 50,
                'menu_options' => json_encode(['Ayam Bakar', 'Sambal Matah', 'Lalapan', 'Es Teh']),
                'is_active' => true,
            ],
            [
                'name' => 'Nasibox Ikan Goreng',
                'slug' => 'nasibox-ikan-goreng',
                'description' => 'Paket nasibox berisi nasi putih, ikan goreng, sambal pedas, dan lalapan',
                'price' => 40000,
                'stock' => 50,
                'menu_options' => json_encode(['Ikan Goreng', 'Sambal Pedas', 'Lalapan', 'Es Jeruk']),
                'is_active' => true,
            ],
            [
                'name' => 'Nasibox Daging Rendang',
                'slug' => 'nasibox-daging-rendang',
                'description' => 'Paket nasibox berisi nasi putih, daging rendang, sambal bawang, dan sayuran',
                'price' => 45000,
                'stock' => 50,
                'menu_options' => json_encode(['Daging Rendang', 'Lalapan', 'Sambal Bawang', 'Es Teh']),
                'is_active' => true,
            ],
            [
                'name' => 'Nasibox Telur Mata Sapi',
                'slug' => 'nasibox-telur-mata-sapi',
                'description' => 'Paket nasibox berisi nasi putih, telur mata sapi, dan lalapan',
                'price' => 28000,
                'stock' => 60,
                'menu_options' => json_encode(['Telur Mata Sapi', 'Lalapan', 'Sambal', 'Es Teh']),
                'is_active' => true,
            ],
        ];

        foreach ($nasiboxProducts as $product) {
            $product['category_id'] = $nasiboxCategory->id;
            Product::create($product);
        }

        // Catering Prasmanan Products
        $cateringCategory = Category::where('slug', 'catering-prasmanan')->first();

        $cateringProducts = [
            [
                'name' => 'Paket Prasmanan 50 Orang',
                'slug' => 'paket-prasmanan-50',
                'description' => 'Paket catering prasmanan lengkap untuk 50 orang dengan berbagai menu pilihan',
                'price' => 1500000,
                'stock' => 10,
                'menu_options' => json_encode([
                    'Ayam Goreng',
                    'Daging Rendang',
                    'Ikan Bakar',
                    'Sayuran Gorengan',
                    'Nasi Kuning',
                    'Es Cendol'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Paket Prasmanan 100 Orang',
                'slug' => 'paket-prasmanan-100',
                'description' => 'Paket catering prasmanan lengkap untuk 100 orang dengan berbagai menu pilihan',
                'price' => 2800000,
                'stock' => 10,
                'menu_options' => json_encode([
                    'Ayam Goreng',
                    'Daging Rendang',
                    'Ikan Bakar',
                    'Sayuran Gorengan',
                    'Nasi Kuning',
                    'Es Cendol',
                    'Krupuk'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Paket Prasmanan 150 Orang',
                'slug' => 'paket-prasmanan-150',
                'description' => 'Paket catering prasmanan premium untuk 150 orang',
                'price' => 4000000,
                'stock' => 8,
                'menu_options' => json_encode([
                    'Ayam Goreng',
                    'Ayam Bakar',
                    'Daging Rendang',
                    'Ikan Bakar',
                    'Udang Goreng',
                    'Sayuran Gorengan',
                    'Nasi Kuning',
                    'Es Cendol'
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($cateringProducts as $product) {
            $product['category_id'] = $cateringCategory->id;
            Product::create($product);
        }

        // Tumpengan Products
        $tumpenanCategory = Category::where('slug', 'tumpengan')->first();

        $tumpenanProducts = [
            [
                'name' => 'Tumpengan Standar',
                'slug' => 'tumpengan-standar',
                'description' => 'Tumpengan tradisional berisi nasi tumpeng dan berbagai lauk pauk',
                'price' => 350000,
                'stock' => 20,
                'menu_options' => json_encode([
                    'Ayam Goreng',
                    'Telur Rebus',
                    'Sayuran',
                    'Sambal',
                    'Krupuk'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Tumpengan Premium',
                'slug' => 'tumpengan-premium',
                'description' => 'Tumpengan premium dengan berbagai lauk pauk pilihan dan presentasi menarik',
                'price' => 500000,
                'stock' => 15,
                'menu_options' => json_encode([
                    'Ayam Bakar',
                    'Daging Goreng',
                    'Ikan Goreng',
                    'Udang Goreng',
                    'Sayuran',
                    'Sambal Premium'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Tumpengan Eksklusif',
                'slug' => 'tumpengan-eksklusif',
                'description' => 'Tumpengan eksklusif dengan berbagai lauk pauk premium untuk acara spesial',
                'price' => 750000,
                'stock' => 10,
                'menu_options' => json_encode([
                    'Ayam Bakar Madu',
                    'Daging Rendang Premium',
                    'Ikan Bakar Butter',
                    'Udang Goreng Bawang',
                    'Sayuran Gorengan Spesial',
                    'Sambal Premium',
                    'Krupuk Besar'
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($tumpenanProducts as $product) {
            $product['category_id'] = $tumpenanCategory->id;
            Product::create($product);
        }
    }
}
