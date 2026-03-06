<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'title' => 'Indian Unicorn Founders',
                'description' => 'Insights and stories from the founders of India\'s most successful billion-dollar startups. Learn how they scaled in a dynamic market.',
                'cover_image' => 'https://images.unsplash.com/photo-1532619675605-1ede6c2ed2b0?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'title' => 'Y Combinator Founders',
                'description' => 'Advice, pitches, and interviews from alumni of the world\'s most prestigious startup accelerator.',
                'cover_image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'title' => 'Women in Tech',
                'description' => 'Inspiring journeys, profound insights, and leadership masterclasses from top female founders and executives in the tech industry.',
                'cover_image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'title' => 'Web3 & Crypto Founders',
                'description' => 'Deep dives into decentralized networks, blockchain architecture, and the future of finance from visionary Web3 pioneers.',
                'cover_image' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?auto=format&fit=crop&q=80&w=800'
            ]
        ];

        foreach ($collections as $colData) {
            $colData['slug'] = Str::slug($colData['title']);
            
            $collection = Collection::firstOrCreate(
                ['slug' => $colData['slug']],
                $colData
            );

            // Attach 3-4 random videos if not already attached
            if ($collection->videos()->count() === 0) {
                $videos = Video::inRandomOrder()->take(rand(3, 4))->pluck('id');
                $collection->videos()->attach($videos);
            }
        }
    }
}
