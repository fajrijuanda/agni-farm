<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bibit Buah',
                'slug' => 'bibit-buah',
                'description' => 'Berbagai bibit tanaman buah berkualitas tinggi',
                'icon' => '🍎',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Bibit Sayuran',
                'slug' => 'bibit-sayuran',
                'description' => 'Bibit sayuran organik dan hibrida',
                'icon' => '🥬',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Tanaman Hias',
                'slug' => 'tanaman-hias',
                'description' => 'Tanaman hias untuk mempercantik rumah',
                'icon' => '🌺',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Bibit Herbal',
                'slug' => 'bibit-herbal',
                'description' => 'Tanaman herbal dan rempah-rempah',
                'icon' => '🌿',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Bibit Pohon',
                'slug' => 'bibit-pohon',
                'description' => 'Bibit pohon peneduh dan produktif',
                'icon' => '🌳',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Kaktus & Sukulen',
                'slug' => 'kaktus-sukulen',
                'description' => 'Koleksi kaktus dan sukulen unik',
                'icon' => '🌵',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
