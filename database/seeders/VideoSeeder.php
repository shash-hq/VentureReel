<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\User;
use App\Models\Category;
use App\Services\YouTubeService;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $youtube = new YouTubeService();

        $videos = [
            // FinTech
            [
                'title' => 'How to Evaluate Startup Ideas',
                'description' => 'Kevin Hale from Y Combinator teaches founders how to evaluate and pitch their startup ideas to investors effectively.',
                'youtube_url' => 'https://www.youtube.com/watch?v=ii1jcLg-eIQ',
                'entrepreneur_name' => 'Kevin Hale',
                'business_name' => 'Y Combinator',
                'tags' => 'fintech,startup,ideas,investing',
                'category' => 'FinTech',
            ],
            [
                'title' => 'Competition is for Losers',
                'description' => 'Peter Thiel explains why monopolies are good and why startups should aim to create new markets rather than competing in existing ones.',
                'youtube_url' => 'https://www.youtube.com/watch?v=Gk-9Fd2mEnI',
                'entrepreneur_name' => 'Peter Thiel',
                'business_name' => 'Palantir / Founders Fund',
                'tags' => 'investing,monopoly,strategy',
                'category' => 'FinTech',
            ],

            // SaaS
            [
                'title' => 'How to Build a Product',
                'description' => 'Michael Seibel explains the framework for building your first product, launching quickly, and talking to users.',
                'youtube_url' => 'https://www.youtube.com/watch?v=CBYhVcO4WgI',
                'entrepreneur_name' => 'Michael Seibel',
                'business_name' => 'Twitch / Y Combinator',
                'tags' => 'saas,product,startup',
                'category' => 'SaaS',
            ],
            [
                'title' => 'How to Succeed with a Startup',
                'description' => 'Sam Altman shares the key attributes of the most successful startups, from idea to execution and team building.',
                'youtube_url' => 'https://www.youtube.com/watch?v=0lJKucu6HJc',
                'entrepreneur_name' => 'Sam Altman',
                'business_name' => 'Y Combinator / OpenAI',
                'tags' => 'saas,startup,success,strategy',
                'category' => 'SaaS',
            ],

            // EdTech
            [
                'title' => 'Making Language Learning Free',
                'description' => 'Luis von Ahn created reCAPTCHA and Duolingo. Learn how he used gamification to make language learning addictive and accessible to millions.',
                'youtube_url' => 'https://www.youtube.com/watch?v=P6FORpg0KVo',
                'entrepreneur_name' => 'Luis von Ahn',
                'business_name' => 'Duolingo',
                'tags' => 'edtech,gamification,languages',
                'category' => 'EdTech',
            ],
            [
                'title' => 'How to Get Startup Ideas',
                'description' => 'Paul Graham explains how the best startup ideas come from noticing problems in your own life, and why most people filter out good ideas.',
                'youtube_url' => 'https://www.youtube.com/watch?v=uvw-u99yj8w',
                'entrepreneur_name' => 'Paul Graham',
                'business_name' => 'Y Combinator',
                'tags' => 'edtech,ideas,startup,founders',
                'category' => 'EdTech',
            ],

            // HealthTech
            [
                'title' => 'How to Get Rich',
                'description' => 'Naval Ravikant shares his framework for building wealth through leverage, specific knowledge, and accountability.',
                'youtube_url' => 'https://www.youtube.com/watch?v=1-TZqOsVCNM',
                'entrepreneur_name' => 'Naval Ravikant',
                'business_name' => 'AngelList',
                'tags' => 'wealth,investing,philosophy',
                'category' => 'HealthTech',
            ],
            [
                'title' => 'Starting a Company',
                'description' => 'Elon Musk shares advice on starting companies, taking risks, and thinking from first principles.',
                'youtube_url' => 'https://www.youtube.com/watch?v=NV2DPudkWlk',
                'entrepreneur_name' => 'Elon Musk',
                'business_name' => 'Tesla / SpaceX',
                'tags' => 'healthtech,innovation,engineering',
                'category' => 'HealthTech',
            ],

            // E-Commerce
            [
                'title' => 'Shopify: Arming the Rebels',
                'description' => 'Tobias Lütke built Shopify because he couldn\'t find a good platform to sell snowboards online. A story of solving your own problem.',
                'youtube_url' => 'https://www.youtube.com/watch?v=Th7XN__ltyc',
                'entrepreneur_name' => 'Tobias Lütke',
                'business_name' => 'Shopify',
                'tags' => 'ecommerce,platform,saas',
                'category' => 'E-Commerce',
            ],
            [
                'title' => 'Scaling Airbnb to Millions of Users',
                'description' => 'Brian Chesky shares the early days of Airbnb, doing things that do not scale, and redesigning the entire guest experience.',
                'youtube_url' => 'https://www.youtube.com/watch?v=pW-SOdj4Kkk',
                'entrepreneur_name' => 'Brian Chesky',
                'business_name' => 'Airbnb',
                'tags' => 'ecommerce,marketplace,scaling',
                'category' => 'E-Commerce',
            ]
        ];

        foreach ($videos as $videoData) {
            $category = $categories->firstWhere('name', $videoData['category']);
            $user = $users->random();

            unset($videoData['category']);

            // Extract YouTube video ID from URL
            preg_match('/[?&]v=([^&]+)/', $videoData['youtube_url'], $matches);
            $youtubeVideoId = $matches[1] ?? '';

            // Fetch real channel name + thumbnail from YouTube API
            $channelName = null;
            $thumbnailUrl = null;
            $duration = null;

            if ($youtubeVideoId && $youtube->isConfigured()) {
                $details = $youtube->getVideoDetails($youtubeVideoId);
                if ($details) {
                    $channelName = $details['channel_title'] ?? null;
                    $thumbnailUrl = $details['thumbnail_url'] ?? null;
                    $duration = $details['duration'] ?? null;
                }
            }

            Video::create(array_merge($videoData, [
                'user_id' => $user->id,
                'category_id' => $category?->id,
                'channel_name' => $channelName,
                'thumbnail_url' => $thumbnailUrl,
                'duration' => $duration,
                'is_approved' => true,
                'approved_at' => now(),
                'views_count' => rand(50, 5000),
            ]));
        }
    }
}
