<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class YouTubeService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('youtube.api_key', '');
    }

    /**
     * Check if the API key is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Get video details by YouTube video ID.
     */
    public function getVideoDetails(string $videoId): ?array
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $cacheKey = "yt_video_{$videoId}";

        if (Cache::has($cacheKey)) {
            \Illuminate\Support\Facades\Log::info("YouTube API: video details for '{$videoId}' served from CACHE");
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::get("{$this->baseUrl}/videos", [
                'key' => $this->apiKey,
                'id' => $videoId,
                'part' => 'snippet,contentDetails,statistics',
            ]);

            if ($response->status() === 403) {
                \Illuminate\Support\Facades\Log::warning("YouTube API Quota Exceeded (403) for getVideoDetails", ['video_id' => $videoId]);
                return null;
            }

            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error("YouTube API Error for getVideoDetails", ['status' => $response->status()]);
                return null;
            }

            $items = $response->json('items', []);
            if (empty($items)) {
                return null;
            }

            $item = $items[0];
            $snippet = $item['snippet'] ?? [];
            $stats = $item['statistics'] ?? [];
            $details = $item['contentDetails'] ?? [];

            $data = [
                'title' => $snippet['title'] ?? '',
                'description' => $snippet['description'] ?? '',
                'channel_title' => $snippet['channelTitle'] ?? '',
                'thumbnail_url' => $this->getBestThumbnail($snippet['thumbnails'] ?? []),
                'published_at' => $snippet['publishedAt'] ?? null,
                'duration' => $this->parseDuration($details['duration'] ?? ''),
                'view_count' => (int) ($stats['viewCount'] ?? 0),
                'like_count' => (int) ($stats['likeCount'] ?? 0),
            ];

            Cache::put($cacheKey, $data, 86400); // 24 hours
            \Illuminate\Support\Facades\Log::info("YouTube API: video details for '{$videoId}' fetched LIVE");

            return $data;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("YouTube API Exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Search YouTube for videos matching a query.
     */
    public function searchVideos(string $query, int $maxResults = 10, ?string $publishedAfter = null): array
    {
        if (!$this->isConfigured()) {
            return ['results' => [], 'cached' => false];
        }

        $cacheKey = 'yt_search_' . md5($query . $maxResults . $publishedAfter);

        if (Cache::has($cacheKey)) {
            \Illuminate\Support\Facades\Log::info("YouTube API: search for '{$query}' served from CACHE");
            return [
                'results' => Cache::get($cacheKey),
                'cached' => true
            ];
        }

        try {
            $params = [
                'key' => $this->apiKey,
                'q' => $query,
                'part' => 'snippet',
                'type' => 'video',
                'maxResults' => $maxResults,
                'order' => 'viewCount',
                'relevanceLanguage' => 'en',
            ];

            if ($publishedAfter) {
                $params['publishedAfter'] = $publishedAfter;
            }

            $response = Http::get("{$this->baseUrl}/search", $params);

            if ($response->status() === 403) {
                \Illuminate\Support\Facades\Log::warning("YouTube API Quota Exceeded (403) on Search", ['query' => $query]);
                return ['results' => [], 'cached' => false];
            }

            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error("YouTube API Error on Search", ['status' => $response->status()]);
                return ['results' => [], 'cached' => false];
            }

            $results = collect($response->json('items', []))->map(function ($item) {
                $snippet = $item['snippet'] ?? [];
                return [
                    'video_id' => $item['id']['videoId'] ?? '',
                    'title' => $snippet['title'] ?? '',
                    'description' => $snippet['description'] ?? '',
                    'channel_title' => $snippet['channelTitle'] ?? '',
                    'thumbnail_url' => $this->getBestThumbnail($snippet['thumbnails'] ?? []),
                    'published_at' => $snippet['publishedAt'] ?? null,
                    'youtube_url' => 'https://www.youtube.com/watch?v=' . ($item['id']['videoId'] ?? ''),
                ];
            })->toArray();

            Cache::put($cacheKey, $results, 86400); // 24 hours TTL
            \Illuminate\Support\Facades\Log::info("YouTube API: search for '{$query}' fetched LIVE");

            return [
                'results' => $results,
                'cached' => false
            ];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("YouTube API Exception on Search: " . $e->getMessage());
            return ['results' => [], 'cached' => false];
        }
    }

    public function getTrendingStartupVideos(int $maxResults = 8): array
    {
        $oneWeekAgo = now()->subDays(7)->toIso8601String();
        $response = $this->searchVideos('startup founder talk pitch', $maxResults, $oneWeekAgo);
        return $response['results'] ?? [];
    }

    /**
     * Get the highest resolution thumbnail available.
     */
    protected function getBestThumbnail(array $thumbnails): string
    {
        foreach (['maxres', 'standard', 'high', 'medium', 'default'] as $quality) {
            if (isset($thumbnails[$quality]['url'])) {
                return $thumbnails[$quality]['url'];
            }
        }
        return '';
    }

    /**
     * Parse ISO 8601 duration (PT4M13S) to human-readable (4:13).
     */
    protected function parseDuration(string $duration): string
    {
        if (empty($duration)) return '';

        preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/', $duration, $matches);

        $hours = (int) ($matches[1] ?? 0);
        $minutes = (int) ($matches[2] ?? 0);
        $seconds = (int) ($matches[3] ?? 0);

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
