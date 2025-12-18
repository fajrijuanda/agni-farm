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
            $regionSlug = $admin->region->slug ?? 'karawang';
            $regionalProducts = $this->getProductsForRegion($regionSlug);

            foreach ($regionalProducts as $productData) {
                $category = $categories[$productData['category']] ?? $categories->first();

                if (!$category) continue;

                $specs = $productData['specs'] ?? [];
                $imageFile = $productData['image'] ?? null;

                $data = $productData;
                unset($data['category'], $data['specs'], $data['image']);

                $product = Product::create(array_merge($data, [
                    'slug' => Str::slug($data['name']),
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

    private function getProductsForRegion(string $slug): array
    {
        switch ($slug) {
            case 'jakarta':
                return [
                    [
                        'category' => 'bibit-sayuran',
                        'name' => 'Starter Kit Hidroponik Pemula',
                        'short_description' => 'Paket lengkap belajar hidroponik sistem wick',
                        'full_description' => 'Paket belajar hidroponik lengkap untuk pemula. Terdiri dari bak nutrisi, netpot, rockwool, benih selada/kangkung, dan nutrisi AB Mix. Sangat mudah dipraktikkan di rumah.',
                        'price' => 125000,
                        'discount_price' => 110000,
                        'is_featured' => true,
                        'image' => 'product-hidroponik-kit.png',
                        'specs' => ['Isi Paket' => 'Bak, 9 Netpot, Rockwool, Benih, AB Mix', 'Sistem' => 'Wick System', 'Berat' => '1 kg'],
                    ],
                    [
                        'category' => 'tanaman-hias',
                        'name' => 'Tanaman Lidah Mertua (Sansevieria)',
                        'short_description' => 'Tanaman pembersih udara anti polutan',
                        'full_description' => 'Lidah Mertua atau Sansevieria adalah tanaman hias yang sangat efektif menyerap polutan udara seperti CO2, benzena, dan formaldehid. Perawatan sangat mudah dan tahan banting.',
                        'price' => 45000,
                        'discount_price' => null,
                        'is_featured' => false,
                        'image' => 'article-indoor-plant.jpg', // Reuse or generic
                        'specs' => ['Tinggi' => '30-40 cm', 'Pot' => 'Plastik Hitam', 'Kebutuhan Cahaya' => 'Tahan Teduh/Panas'],
                    ],
                    [
                        'category' => 'bibit-sayuran',
                        'name' => 'Benih Selada Green Romaine',
                        'short_description' => 'Benih selada impor renyah untuk salad',
                        'full_description' => 'Benih selada jenis Romaine yang memiliki tekstur renyah dan rasa manis. Sangat cocok untuk salad atau lalapan. Bisa ditanam secara hidroponik maupun konvensional.',
                        'price' => 15000,
                        'discount_price' => null,
                        'is_featured' => false,
                        'image' => 'article-urban-farming.jpg', // Reuse or generic
                        'specs' => ['Isi' => '200 butir', 'Kemasan' => 'Aluminium Foil', 'Daya Berkecambah' => '85%'],
                    ],
                ];
            case 'bogor':
                return [
                    [
                        'category' => 'bibit-buah', // Or create tea category? Using vegetable/fruit for now
                        'name' => 'Bibit Tanaman Teh (Camellia Sinensis)',
                        'short_description' => 'Bibit teh unggul pucuk merah',
                        'full_description' => 'Bibit tanaman teh kualitas unggul. Selain untuk dipanen daunnya, tanaman ini juga cantik sebagai tanaman pagar atau hiasan taman. Cocok di dataran tinggi.',
                        'price' => 25000,
                        'discount_price' => null,
                        'is_featured' => true,
                        'image' => 'product-bibit-teh.png',
                        'specs' => ['Tinggi' => '20-30 cm', 'Asal' => 'Stek', 'Dataran' => 'Tinggi (Sejuk)'],
                    ],
                    [
                        'category' => 'tanaman-hias',
                        'name' => 'Anggrek Bulan Putih Dewasa',
                        'short_description' => 'Anggrek bulan bunga besar siap pajang',
                        'full_description' => 'Anggrek bulan (Phalaenopsis) warna putih bersih dengan bunga berukuran besar. Sudah dalam kondisi berbunga (knop/mekar). Sangat elegan untuk hiasan ruang tamu.',
                        'price' => 135000,
                        'discount_price' => 125000,
                        'is_featured' => true,
                        'image' => 'article-indoor-plant.jpg', // Reuse
                        'specs' => ['Warna' => 'Putih Bersih', 'Kondisi' => 'Berbunga', 'Media Tanam' => 'Mos Hitam/Putih'],
                    ],
                    [
                        'category' => 'tanaman-hias',
                        'name' => 'Aglaonema Red Anjamani',
                        'short_description' => 'Aglaonema daun merah merona',
                        'full_description' => 'Aglaonema Red Anjamani dengan dominasi warna merah terang pada daunnya. Tanaman hias daun yang populer dan mudah dirawat. Menyukai tempat teduh.',
                        'price' => 85000,
                        'discount_price' => null,
                        'is_featured' => false,
                        'image' => 'article-indoor-plant.jpg', // Reuse
                        'specs' => ['Jumlah Daun' => '5-7 helai', 'Tinggi' => '20-30 cm', 'Asal' => 'Pemisahan Rumpun'],
                    ],
                ];
            case 'bekasi':
                return [
                    [
                        'category' => 'bibit-buah',
                        'name' => 'Bibit Mangga Harum Manis',
                        'short_description' => 'Bibit mangga harum manis unggul',
                        'full_description' => 'Bibit mangga harum manis kualitas super. Pohon mangga ini menghasilkan buah yang sangat manis dengan aroma harum yang khas. Cocok untuk cuaca panas Bekasi.',
                        'price' => 75000,
                        'discount_price' => 65000,
                        'is_featured' => true,
                        'image' => 'mangga-harum-manis.png',
                        'specs' => ['Tinggi' => '50-70 cm', 'Asal' => 'Okulasi', 'Estimasi Buah' => '2-3 tahun'],
                    ],
                    [
                        'category' => 'bibit-buah',
                        'name' => 'Bibit Kelengkeng Itoh',
                        'short_description' => 'Kelengkeng dataran rendah daging tebal',
                        'full_description' => 'Kelengkeng Itoh adalah varietas kelengkeng yang adaptif di dataran rendah dan cuaca panas. Daging buah tebal, biji kecil, dan rasa sangat manis.',
                        'price' => 80000,
                        'discount_price' => null,
                        'is_featured' => true,
                        'image' => 'jeruk-santang-madu.png', // Placeholder reuse
                        'specs' => ['Tinggi' => '50-60 cm', 'Asal' => 'Okulasi', 'Estimasi Buah' => '2 tahun'],
                    ],
                    [
                        'category' => 'tanaman-hias',
                        'name' => 'Pohon Ketapang Kencana',
                        'short_description' => 'Pohon peneduh minimalis',
                        'full_description' => 'Pohon Ketapang Kencana (Terminalia mantaly) sangat populer sebagai pohon peneduh di perumahan modern. Daun kecil bertingkat memberikan kesan rapi dan teduh.',
                        'price' => 150000,
                        'discount_price' => null,
                        'is_featured' => false,
                        'image' => 'article-indoor-plant.jpg', // Reuse
                        'specs' => ['Tinggi' => '1.5 - 2 meter', 'Kondisi' => 'Tampungan', 'Kegunaan' => 'Peneduh'],
                    ],
                ];
            case 'karawang':
            default:
                return [
                    [
                        'category' => 'bibit-buah', // Using available category
                        'name' => 'Bibit Padi Ciherang Jumbo',
                        'short_description' => 'Benih padi unggul tahan wereng',
                        'full_description' => 'Benih Padi Ciherang Jumbo bersertifikat. Varietas unggul yang tahan terhadap hama wereng coklat dan penyakit hawar daun bakteri. Produksi tinggi dan rasa nasi pulen.',
                        'price' => 85000,
                        'discount_price' => null,
                        'is_featured' => true,
                        'image' => 'product-padi-ciherang.png',
                        'specs' => ['Kemasan' => '5 Kg', 'Potensi Hasil' => '10-12 Ton/Ha', 'Umur Panen' => '115-125 HSS'],
                    ],
                    [
                        'category' => 'bibit-buah',
                        'name' => 'Bibit Jeruk Santang Madu',
                        'short_description' => 'Jeruk santang madu manis',
                        'full_description' => 'Bibit jeruk santang madu berkualitas. Bisa ditanam di pot (Tabulampot). Buah oranye cerah dengan rasa manis menyegarkan.',
                        'price' => 65000,
                        'discount_price' => 50000,
                        'is_featured' => false,
                        'image' => 'jeruk-santang-madu.png',
                        'specs' => ['Tinggi' => '40-50 cm', 'Asal' => 'Okulasi', 'Estimasi Buah' => '1-2 tahun'],
                    ],
                    [
                        'category' => 'bibit-buah',
                        'name' => 'Bibit Jambu Kristal',
                        'short_description' => 'Jambu biji renyah tanpa biji',
                        'full_description' => 'Bibit Jambu Kristal okulasi. Jambu biji dengan tekstur renyah seperti apel dan hampir tidak memiliki biji (seedless). Sangat genjah dan rajin berbuah.',
                        'price' => 45000,
                        'discount_price' => null,
                        'is_featured' => false,
                        'image' => 'mangga-harum-manis.png', // Placeholder reuse
                        'specs' => ['Tinggi' => '40-60 cm', 'Asal' => 'Cangkok', 'Estimasi Buah' => '8-12 bulan'],
                    ],
                ];
        }

        $this->command->info('Products seeded successfully!');
    }
}
