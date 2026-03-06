<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'cover_image'];

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
