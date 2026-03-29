<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hair Salon', 'slug' => 'hair-salon', 'icon' => '💇', 'description' => 'Haircuts, styling, coloring & treatments', 'sort_order' => 1],
            ['name' => 'Nail Studio', 'slug' => 'nail-studio', 'icon' => '💅', 'description' => 'Manicure, pedicure & nail art', 'sort_order' => 2],
            ['name' => 'Spa & Wellness', 'slug' => 'spa-wellness', 'icon' => '🧖', 'description' => 'Massage, facials & body treatments', 'sort_order' => 3],
            ['name' => 'Barbershop', 'slug' => 'barbershop', 'icon' => '💈', 'description' => "Men's cuts, shaves & grooming", 'sort_order' => 4],
            ['name' => 'Makeup Artist', 'slug' => 'makeup-artist', 'icon' => '💄', 'description' => 'Bridal, editorial & everyday makeup', 'sort_order' => 5],
            ['name' => 'Skincare', 'slug' => 'skincare', 'icon' => '✨', 'description' => 'Facials, peels & skin treatments', 'sort_order' => 6],
            ['name' => 'Massage', 'slug' => 'massage', 'icon' => '💆', 'description' => 'Deep tissue, Swedish & therapeutic', 'sort_order' => 7],
            ['name' => 'Fitness', 'slug' => 'fitness', 'icon' => '🏋️', 'description' => 'Personal training & yoga', 'sort_order' => 8],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
