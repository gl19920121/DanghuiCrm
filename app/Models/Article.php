<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\ArticleType;
use App\Models\User;

class Article extends Model
{
    protected $appends = ['cover_url'];

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function articleType()
    {
        return $this->belongsTo(ArticleType::class, 'article_types_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getCoverUrlAttribute()
    {
        return Storage::disk('article_cover')->url($this->attributes['cover']);
    }
}
