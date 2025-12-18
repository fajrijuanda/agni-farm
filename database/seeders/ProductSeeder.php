<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all regional admins
        $admins = User::where('role', 'admin')
            ->whereNotNull('region_id')
            ->get();

        if ($admins->isEmpty()) {
            $this->command->warn('No regional admins found. Please run AdminSeeder first.');
            return;
        }

        // Get categories
        $categories = \App\Models\Category::all()->keyBy('slug');

        $baseProducts = [
            // Bibit Buah
            [
                'category' => 'bibit-buah',
                'name' => 'Bibit Mangga Harum Manis',
                'short_description' => 'Bibit mangga harum manis unggul, buah manis dan harum',
                'full_description' => 'Bibit mangga harum manis kualitas super. Pohon mangga ini menghasilkan buah yang sangat manis dengan aroma harum yang khas. Cocok ditanam di dataran rendah hingga menengah. Tinggi bibit 40-60cm, sudah siap tanam.',
                'price' => 75000,
                'discount_price' => 65000,
                'is_featured' => true,
                'image' => 'mangga-harum-manis.png',
                'specs' => [
                    'Tinggi Bibit' => '40-60 cm',
                    'Umur Bibit' => '6-8 bulan',
                    'Asal Bibit' => 'Cangkok/Okulasi',
                    'Waktu Berbuah' => '2-3 tahun',
                ],
            ],
            [
                'category' => 'bibit-buah',
                'name' => 'Bibit Durian Musang King',
                'short_description' => 'Bibit durian musang king asli, daging tebal kuning',
                'full_description' => 'Bibit durian musang king premium. Varietas durian paling populer dengan daging buah tebal berwarna kuning pekat dan rasa yang sangat manis. Bibit hasil okulasi, cepat berbuah.',
                'price' => 250000,
                'discount_price' => null,
                'is_featured' => true,
                'image' => 'durian-musang-king.png',
                'specs' => [
                    'Tinggi Bibit' => '50-70 cm',
                    'Umur Bibit' => '8-12 bulan',
                    'Asal Bibit' => 'Okulasi',
                    'Waktu Berbuah' => '4-5 tahun',
                ],
            ],
            [
                'category' => 'bibit-buah',
                'name' => 'Bibit Jeruk Santang Madu',
                'short_description' => 'Jeruk santang madu manis tanpa biji',
                'full_description' => 'Bibit jeruk santang madu berkualitas tinggi. Buah berukuran sedang dengan rasa yang sangat manis seperti madu dan hampir tanpa biji. Cocok untuk pot atau di tanah langsung.',
                'price' => 85000,
                'discount_price' => 70000,
                'is_featured' => true,
                'image' => 'jeruk-santang-madu.png',
                'specs' => [
                    'Tinggi Bibit' => '30-50 cm',
                    'Umur Bibit' => '6 bulan',
                    'Asal Bibit' => 'Cangkok',
                    'Waktu Berbuah' => '1-2 tahun',
                ],
            ],
        ];

        foreach ($admins as $admin) {
            foreach ($baseProducts as $productData) {
                $category = $categories[$productData['category']] ?? null;

                if (!$category) continue;

                $specs = $productData['specs'] ?? [];
                $imageFile = $productData['image'] ?? null;

                // Create a clean copy of data to modify
                $data = $productData;
                unset($data['category'], $data['specs'], $data['image']);

                // Ensure unique name/slug per region
                $productName = $data['name'] . ' - ' . $admin->region->name;

                $product = Product::create(array_merge($data, [
                    'name' => $productName,
                    'slug' => Str::slug($productName),
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'region_id' => $admin->region_id,
                    'shopee_link' => $admin->region->shopee_url ?? '#',
                    'is_active' => true,
                    'sort_order' => 0,
                ]));

                // Add specifications
                foreach ($specs as $key => $value) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'key' => $key,
                        'value' => $value,
                        'sort_order' => 0
                    ]);
                }

                // Add Image
                if ($imageFile) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'products/' . $imageFile,
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]);
                }
            }
        }

        $this->command->info('Products seeded successfully!');
    }
}
