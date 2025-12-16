<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageMap = [
            'bibit-mangga-harum-manis' => 'products/mangga.png',
            'bibit-durian-musang-king' => 'products/durian.png',
            'bibit-jeruk-santang-madu' => 'products/jeruk.png',
            'aglonema-red-sumatra' => 'products/aglonema.png',
        ];

        foreach ($imageMap as $slug => $imagePath) {
            $product = Product::where('slug', $slug)->first();

            if ($product) {
                ProductImage::updateOrCreate(
                    ['product_id' => $product->id, 'image_path' => $imagePath],
                    [
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]
                );
            }
        }

        $this->command->info('Product images seeded successfully!');
    }
}
