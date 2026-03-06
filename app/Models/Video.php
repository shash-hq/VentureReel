<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'youtube_url',
        'youtube_video_id',
        'duration',
        'channel_name',
        'thumbnail_path',
        'thumbnail_url',
        'entrepreneur_name',
        'business_name',
        'tags',
        'views_count',
        'is_approved',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    // ── Scopes ──

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('is_approved', false);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('entrepreneur_name', 'LIKE', "%{$search}%")
              ->orWhere('business_name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('tags', 'LIKE', "%{$search}%");
        });
    }

    // ── Auto-generate slug and extract YouTube ID ──

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Video $video) {
            if (empty($video->slug)) {
                $base = Str::slug($video->title);
                $slug = $base;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $count++;
                }
                $video->slug = $slug;
            }

            if (empty($video->youtube_video_id) && !empty($video->youtube_url)) {
                $video->youtube_video_id = static::extractYouTubeId($video->youtube_url);
            }
        });
    }

    // ── Helpers ──

    public static function extractYouTubeId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_video_id}";
    }

    public function getThumbnailUrlAttribute(): string
    {
        // 1. Custom uploaded thumbnail
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }

        // 2. YouTube API-fetched thumbnail
        if ($this->attributes['thumbnail_url'] ?? null) {
            return $this->attributes['thumbnail_url'];
        }

        // 3. Fall back to YouTube default (hqdefault is always available)
        return "https://img.youtube.com/vi/{$this->youtube_video_id}/hqdefault.jpg";
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }
        return array_map('trim', explode(',', $this->tags));
    }
}
