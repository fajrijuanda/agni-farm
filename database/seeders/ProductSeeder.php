<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
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
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $this->command->error('Please run AdminSeeder first!');
            return;
        }

        // Get categories
        $categories = Category::all()->keyBy('slug');

        $products = [
            // Bibit Buah
            [
                'category' => 'bibit-buah',
                'name' => 'Bibit Mangga Harum Manis',
                'short_description' => 'Bibit mangga harum manis unggul, buah manis dan harum',
                'full_description' => 'Bibit mangga harum manis kualitas super. Pohon mangga ini menghasilkan buah yang sangat manis dengan aroma harum yang khas. Cocok ditanam di dataran rendah hingga menengah. Tinggi bibit 40-60cm, sudah siap tanam.',
                'price' => 75000,
                'discount_price' => 65000,
                'is_featured' => true,
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
                'specs' => [
                    'Tinggi Bibit' => '30-50 cm',
                    'Umur Bibit' => '6 bulan',
                    'Asal Bibit' => 'Cangkok',
                    'Waktu Berbuah' => '1-2 tahun',
                ],
            ],
            [
                'category' => 'bibit-buah',
                'name' => 'Bibit Alpukat Mentega',
                'short_description' => 'Alpukat mentega daging tebal lembut',
                'full_description' => 'Bibit alpukat mentega super. Daging buah tebal dengan tekstur lembut seperti mentega. Sangat populer untuk dijadikan jus. Pohon tumbuh subur dan produktif.',
                'price' => 95000,
                'discount_price' => null,
                'is_featured' => false,
                'specs' => [
                    'Tinggi Bibit' => '40-60 cm',
                    'Umur Bibit' => '8 bulan',
                    'Asal Bibit' => 'Cangkok',
                    'Waktu Berbuah' => '2-3 tahun',
                ],
            ],

            // Bibit Sayuran
            [
                'category' => 'bibit-sayuran',
                'name' => 'Bibit Cabai Rawit Domba',
                'short_description' => 'Cabai rawit domba super pedas produktif',
                'full_description' => 'Bibit cabai rawit domba unggul dengan tingkat kepedasan tinggi. Tanaman produktif dengan buah lebat. Cocok untuk budidaya komersial maupun rumahan.',
                'price' => 15000,
                'discount_price' => 12000,
                'is_featured' => true,
                'specs' => [
                    'Isi' => '50 biji',
                    'Daya Tumbuh' => '85%',
                    'Umur Panen' => '75-90 hari',
                    'Produktivitas' => 'Tinggi',
                ],
            ],
            [
                'category' => 'bibit-sayuran',
                'name' => 'Bibit Tomat Cherry',
                'short_description' => 'Tomat cherry manis untuk salad',
                'full_description' => 'Bibit tomat cherry premium. Buah kecil bulat dengan rasa manis, cocok untuk salad atau dimakan langsung. Tanaman mudah dirawat dan produktif.',
                'price' => 20000,
                'discount_price' => null,
                'is_featured' => false,
                'specs' => [
                    'Isi' => '30 biji',
                    'Daya Tumbuh' => '90%',
                    'Umur Panen' => '60-70 hari',
                    'Warna Buah' => 'Merah',
                ],
            ],

            // Tanaman Hias
            [
                'category' => 'tanaman-hias',
                'name' => 'Aglonema Red Sumatra',
                'short_description' => 'Aglonema merah cantik untuk indoor',
                'full_description' => 'Aglonema Red Sumatra dengan warna daun merah menyala yang cantik. Tanaman hias indoor yang mudah perawatan dan tahan naungan. Cocok untuk mempercantik ruangan.',
                'price' => 150000,
                'discount_price' => 125000,
                'is_featured' => true,
                'specs' => [
                    'Ukuran Pot' => '12 cm',
                    'Tinggi Tanaman' => '20-30 cm',
                    'Pencahayaan' => 'Teduh',
                    'Penyiraman' => '2-3x seminggu',
                ],
            ],
            [
                'category' => 'tanaman-hias',
                'name' => 'Monstera Deliciosa',
                'short_description' => 'Monstera daun berlubang aesthetic',
                'full_description' => 'Monstera Deliciosa dengan daun besar berlubang yang ikonik. Tanaman hias favorit untuk interior modern dan aesthetic. Mudah dirawat dan tumbuh cepat.',
                'price' => 175000,
                'discount_price' => null,
                'is_featured' => true,
                'specs' => [
                    'Ukuran Pot' => '15 cm',
                    'Tinggi Tanaman' => '30-40 cm',
                    'Pencahayaan' => 'Terang tidak langsung',
                    'Penyiraman' => '1-2x seminggu',
                ],
            ],

            // Bibit Herbal
            [
                'category' => 'bibit-herbal',
                'name' => 'Bibit Jahe Merah',
                'short_description' => 'Jahe merah berkhasiat tinggi',
                'full_description' => 'Bibit jahe merah organik dengan kandungan gingerol tinggi. Berkhasiat untuk kesehatan dan sangat cocok untuk budidaya herbal. Rimpang besar dan produktif.',
                'price' => 25000,
                'discount_price' => 20000,
                'is_featured' => false,
                'specs' => [
                    'Isi' => '5 rimpang',
                    'Berat' => '250 gram',
                    'Umur Panen' => '8-10 bulan',
                    'Khasiat' => 'Tinggi Antioksidan',
                ],
            ],
            [
                'category' => 'bibit-herbal',
                'name' => 'Bibit Rosemary',
                'short_description' => 'Rosemary harum untuk bumbu dan aromaterapi',
                'full_description' => 'Bibit rosemary segar dengan aroma khas yang menenangkan. Cocok untuk bumbu masakan mediterania dan aromaterapi. Tanaman perennial yang mudah dirawat.',
                'price' => 35000,
                'discount_price' => null,
                'is_featured' => false,
                'specs' => [
                    'Ukuran Pot' => '10 cm',
                    'Tinggi' => '15-20 cm',
                    'Pencahayaan' => 'Full Sun',
                    'Penyiraman' => 'Sedang',
                ],
            ],

            // Kaktus & Sukulen
            [
                'category' => 'kaktus-sukulen',
                'name' => 'Echeveria Lola',
                'short_description' => 'Sukulen rosette ungu cantik',
                'full_description' => 'Echeveria Lola dengan bentuk rosette sempurna dan warna ungu keabu-abuan yang menawan. Sukulen favorit kolektor dengan perawatan minimal.',
                'price' => 45000,
                'discount_price' => 38000,
                'is_featured' => true,
                'specs' => [
                    'Diameter' => '8-10 cm',
                    'Warna' => 'Ungu Keabu-abuan',
                    'Pencahayaan' => 'Terang',
                    'Penyiraman' => '1x seminggu',
                ],
            ],
            [
                'category' => 'kaktus-sukulen',
                'name' => 'Kaktus Moon',
                'short_description' => 'Kaktus warna-warni unik',
                'full_description' => 'Kaktus Moon atau Gymnocalycium dengan kepala warna-warni (merah, kuning, orange) yang menarik. Cocok untuk koleksi atau hadiah.',
                'price' => 55000,
                'discount_price' => null,
                'is_featured' => false,
                'specs' => [
                    'Tinggi' => '10-15 cm',
                    'Warna Kepala' => 'Random',
                    'Pencahayaan' => 'Terang tidak langsung',
                    'Penyiraman' => '2x sebulan',
                ],
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories[$productData['category']] ?? null;

            if (!$category) continue;

            $specs = $productData['specs'] ?? [];
            unset($productData['category'], $productData['specs']);

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($productData['name'])],
                array_merge($productData, [
                    'slug' => Str::slug($productData['name']),
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'shopee_link' => 'https://shopee.co.id/agnifarm',
                    'is_active' => true,
                    'sort_order' => 0,
                ])
            );

            // Add specifications
            foreach ($specs as $key => $value) {
                ProductSpecification::updateOrCreate(
                    ['product_id' => $product->id, 'key' => $key],
                    ['value' => $value, 'sort_order' => 0]
                );
            }
        }

        $this->command->info('Products seeded successfully! (' . count($products) . ' products)');
    }
}
