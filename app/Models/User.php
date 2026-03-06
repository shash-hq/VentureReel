<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar_path',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ──

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function likedVideos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'likes')->withTimestamps();
    }

    public function bookmarkedVideos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'bookmarks')->withTimestamps();
    }

    public function searchHistories(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function activity(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    public function followedCollections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }

    // ── Helpers ──

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasLiked(Video $video): bool
    {
        return $this->likedVideos()->where('video_id', $video->id)->exists();
    }

    public function hasBookmarked(Video $video): bool
    {
        return $this->bookmarkedVideos()->where('video_id', $video->id)->exists();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path) {
            return asset('storage/' . $this->avatar_path);
        }

        // Gravatar fallback
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function getTotalLikesReceivedAttribute(): int
    {
        return $this->videos()->withCount('likes')->get()->sum('likes_count');
    }

    public function getTotalViewsAttribute(): int
    {
        return $this->videos()->sum('views_count');
    }
}
