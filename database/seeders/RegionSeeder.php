<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'name' => 'Karawang',
                'slug' => 'karawang',
                'shopee_url' => 'https://id.shp.ee/jz7iGbm',
                'order_index' => 1,
            ],
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'shopee_url' => 'https://id.shp.ee/gEiQ7H7',
                'order_index' => 2,
            ],
            [
                'name' => 'Bekasi',
                'slug' => 'bekasi',
                'shopee_url' => 'https://id.shp.ee/UfDfwHm',
                'order_index' => 3,
            ],
            [
                'name' => 'Bogor',
                'slug' => 'bogor',
                'shopee_url' => 'https://id.shp.ee/Rmq5vp4',
                'order_index' => 4,
            ],
        ];

        foreach ($regions as $region) {
            Region::updateOrCreate(
                ['slug' => $region['slug']],
                $region
            );
        }
    }
}
