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
            foreach ($baseArticles as $index => $data) {
                // Ensure unique slug for each article by appending random string/id if needed,
                // but since these are unique per region conceptually, maybe just title is enough?
                // Using slug helper handles duplicates by appending count usually? No, Str::slug doesn't.
                // We should append something unique.

                \App\Models\Article::create(array_merge($data, [
                    'user_id' => $admin->id,
                    'title' => $data['title'] . ' (' . $admin->region->name . ')', // Variation to title
                    'slug' => \Illuminate\Support\Str::slug($data['title'] . ' ' . $admin->region->name),
                    'is_published' => true,
                    'published_at' => now(),
                    'views' => rand(500, 2000),
                ]));
            }
        }
    }
}
