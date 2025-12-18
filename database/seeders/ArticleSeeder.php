<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all regional admins (role = admin and region_id is not null)
        $admins = \App\Models\User::where('role', 'admin')
            ->whereNotNull('region_id')
            ->get();

        if ($admins->isEmpty()) {
            $this->command->warn('No regional admins found. Please run AdminSeeder first.');
            return;
        }

        $baseArticles = [
            [
                'title' => 'Cara Merawat Tanaman Hias di Dalam Ruangan',
                'excerpt' => 'Tips jitu merawat tanaman hias agar tetap subur meski di dalam ruangan.',
                'content' => 'Tanaman hias indoor membutuhkan perawatan khusus agar tetap tumbuh sehat. Pastikan pencahayaan cukup meski tidak langsung, penyiraman yang tepat jangan sampai tergenang, dan pemupukan rutin.',
                'image' => 'article-indoor-plant.jpg',
                'views' => 1250,
            ],
            [
                'title' => 'Manfaat Berkebun untuk Kesehatan Mental',
                'excerpt' => 'Berkebun bukan sekadar hobi, tapi juga terapi alami untuk stres.',
                'content' => 'Aktivitas berkebun terbukti dapat menurunkan tingkat stres dan kecemasan. Berinteraksi dengan alam, tanah, dan tanaman hijau memberikan efek menenangkan bagi pikiran.',
                'image' => 'article-gardening-mental-health.jpg',
                'views' => 980,
            ],
            [
                'title' => 'Panduan Memilih Pupuk Organik Terbaik',
                'excerpt' => 'Kenali jenis pupuk organik yang paling cocok untuk tanaman Anda.',
                'content' => 'Pupuk organik sangat baik untuk jangka panjang karena memperbaiki struktur tanah. Pilihlah kompos matang atau pupuk kandang yang sudah difermentasi untuk hasil terbaik.',
                'image' => 'article-organic-fertilizer.jpg',
                'views' => 1500,
            ],
        ];

        foreach ($admins as $admin) {
            $regionSlug = $admin->region->slug ?? 'karawang'; // Default to karawang if null
            $regionalArticles = $this->getArticlesForRegion($regionSlug);

            foreach ($regionalArticles as $data) {
                \App\Models\Article::create(array_merge($data, [
                    'user_id' => $admin->id,
                    'is_published' => true,
                    'published_at' => now(),
                    'views' => rand(500, 2000),
                ]));
            }
        }
    }

    private function getArticlesForRegion(string $slug): array
    {
        switch ($slug) {
            case 'jakarta':
                return [
                    [
                        'title' => 'Hidroponik di Lahan Sempit Jakarta',
                        'slug' => 'hidroponik-di-lahan-sempit-jakarta',
                        'excerpt' => 'Solusi berkebun tanpa tanah untuk warga Jakarta yang memiliki lahan terbatas.',
                        'content' => 'Hidroponik adalah solusi terbaik untuk berkebun di Jakarta. Dengan memanfaatkan pipa PVC atau botol bekas, Anda bisa menanam sayuran segar di balkon apartemen atau teras rumah yang sempit.',
                        'image' => 'article-urban-farming.jpg',
                    ],
                    [
                        'title' => 'Mengatasi Polusi Udara dengan Lidah Mertua',
                        'slug' => 'mengatasi-polusi-udara-dengan-lidah-mertua',
                        'excerpt' => 'Tanaman hias yang ampuh menyerap polutan udara di Jakarta.',
                        'content' => 'Lidah mertua (Sansevieria) dikenal sebagai tanaman anti-polutan. Sangat cocok Ditanam di Jakarta untuk membantu membersihkan udara di dalam ruangan dari racun berbahaya.',
                        'image' => 'article-indoor-plant.jpg', // Reused
                    ],
                    [
                        'title' => 'Panduan Vertical Garden Pemula',
                        'slug' => 'panduan-vertical-garden-pemula',
                        'excerpt' => 'Cara membuat taman vertikal yang estetik di dinding rumah Anda.',
                        'content' => 'Vertical garden tidak hanya menghemat tempat tetapi juga menambah estetika rumah. Gunakan pot dinding atau kantong tanaman gantung untuk menanam berbagai jenis tanaman hias.',
                        'image' => 'article-gardening-mental-health.jpg', // Reused
                    ],
                ];
            case 'bogor':
                return [
                    [
                        'title' => 'Rahasia Kesegaran Teh Puncak Bogor',
                        'slug' => 'rahasia-kesegaran-teh-puncak-bogor',
                        'excerpt' => 'Mengenal kualitas teh terbaik yang dihasilkan dari perkebunan Puncak.',
                        'content' => 'Teh dari Puncak Bogor memiliki aroma dan rasa yang khas karena ditanam di ketinggian yang ideal. Pucuk teh pilihan dipetik manual untuk menjaga kualitasnya.',
                        'image' => 'article-teh.jpg',
                    ],
                    [
                        'title' => 'Merawat Anggrek Bulan di Iklim Sejuk',
                        'slug' => 'merawat-anggrek-bulan-di-iklim-sejuk',
                        'excerpt' => 'Tips agar anggrek bulan rajin berbunga di daerah sejuk seperti Bogor.',
                        'content' => 'Anggrek bulan menyukai kelembaban tinggi dan suhu sejuk seperti di Bogor. Pastikan sirkulasi udara lancar dan pemupukan teratur agar bunganya mekar sempurna.',
                        'image' => 'article-indoor-plant.jpg', // Reused
                    ],
                    [
                        'title' => 'Wisata Edukasi Pertanian di Bogor',
                        'slug' => 'wisata-edukasi-pertanian-di-bogor',
                        'excerpt' => 'Ajak keluarga mengenal dunia pertanian di berbagai agrowisata Bogor.',
                        'content' => 'Bogor menawarkan banyak destinasi agrowisata. Anak-anak bisa belajar menanam padi, memetik sayur, dan berinteraksi dengan hewan ternak secara langsung.',
                        'image' => 'article-gardening-mental-health.jpg', // Reused
                    ],
                ];
            case 'bekasi':
                return [
                    [
                        'title' => 'Pohon Peneduh untuk Cuaca Panas Bekasi',
                        'slug' => 'pohon-peneduh-untuk-cuaca-panas-bekasi',
                        'excerpt' => 'Rekomendasi pohon rindang untuk menyejukkan halaman rumah di Bekasi.',
                        'content' => 'Bekasi yang panas membutuhkan pohon peneduh seperti Ketapang Kencana atau Mangga. Selain meneduhkan, pohon ini juga bisa menghasilkan buah yang segar.',
                        'image' => 'article-mangga.jpg',
                    ],
                    [
                        'title' => 'Budidaya Kelengkeng di Dataran Rendah',
                        'slug' => 'budidaya-kelengkeng-di-dataran-rendah',
                        'excerpt' => 'Jenis kelengkeng yang cocok dan manis ditanam di Bekasi.',
                        'content' => 'Kelengkeng Itoh atau Pingpong sangat cocok untuk dataran rendah seperti Bekasi. Dengan perawatan yang tepat, pohon ini bisa berbuah lebat dan manis.',
                        'image' => 'article-organic-fertilizer.jpg', // Reused
                    ],
                    [
                        'title' => 'Tips Menyiram Tanaman Saat Kemarau',
                        'slug' => 'tips-menyiram-tanaman-saat-kemarau',
                        'excerpt' => 'Cara hemat air namun efektif menjaga tanaman tetap hidup di musim panas.',
                        'content' => 'Saat kemarau panjang di Bekasi, siram tanaman pada pagi atau sore hari untuk mengurangi penguapan. Gunakan air bekas cucian beras sebagai alternatif pupuk cair.',
                        'image' => 'article-indoor-plant.jpg', // Reused
                    ],
                ];
            case 'karawang':
            default:
                return [
                    [
                        'title' => 'Teknik Menanam Padi Metode SRI',
                        'slug' => 'teknik-menanam-padi-metode-sri',
                        'excerpt' => 'Meningkatkan hasil panen padi dengan metode System of Rice Intensification.',
                        'content' => 'Metode SRI terbukti meningkatkan produktivitas padi di Karawang. Kuncinya adalah tanam bibit muda, satu bibit per lubang, dan pengaturan air yang macak-macak.',
                        'image' => 'article-padi.jpg',
                    ],
                    [
                        'title' => 'Mengendalikan Hama Wereng Secara Alami',
                        'slug' => 'mengendalikan-hama-wereng-secara-alami',
                        'excerpt' => 'Cara aman membasmi wereng tanpa merusak ekosistem sawah.',
                        'content' => 'Gunakan musuh alami seperti laba-laba dan kepik untuk mengendalikan wereng. Penanaman tanaman refugia (bunga-bungaan) di pematang sawah juga sangat membantu.',
                        'image' => 'article-organic-fertilizer.jpg', // Reused
                    ],
                    [
                        'title' => 'Sejarah Karawang sebagai Lumbung Padi',
                        'slug' => 'sejarah-karawang-sebagai-lumbung-padi',
                        'excerpt' => 'Mengenal peran penting Karawang dalam ketahanan pangan nasional.',
                        'content' => 'Karawang telah lama dikenal sebagai lumbung padi nasional. Daerah ini memiliki hamparan sawah teknis yang luas dan menjadi penyangga utama kebutuhan beras ibukota.',
                        'image' => 'article-indoor-plant.jpg', // Reused
                    ],
                ];
        }
    }
}
