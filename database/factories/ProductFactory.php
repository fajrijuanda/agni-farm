<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3);
        return [
            'category_id' => Category::factory(),
            'user_id' => \App\Models\User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'short_description' => $this->faker->paragraph,
            'full_description' => $this->faker->text,
            'shopee_link' => $this->faker->url,
            'price' => $this->faker->numberBetween(10000, 100000),
            'is_active' => true,
            'is_featured' => false,
        ];
    }
}
