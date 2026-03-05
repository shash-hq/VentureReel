<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'FinTech',
                'slug' => 'fintech',
                'description' => 'Financial technology startups disrupting banking, payments, and investing.',
                'icon' => '💰',
            ],
            [
                'name' => 'SaaS',
                'slug' => 'saas',
                'description' => 'Software-as-a-Service businesses solving real-world problems.',
                'icon' => '☁️',
            ],
            [
                'name' => 'EdTech',
                'slug' => 'edtech',
                'description' => 'Education technology transforming how we learn.',
                'icon' => '📚',
            ],
            [
                'name' => 'HealthTech',
                'slug' => 'healthtech',
                'description' => 'Healthcare innovation improving patient outcomes.',
                'icon' => '🏥',
            ],
            [
                'name' => 'E-Commerce',
                'slug' => 'e-commerce',
                'description' => 'Online retail and marketplace platforms.',
                'icon' => '🛒',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
