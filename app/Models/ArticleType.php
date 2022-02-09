<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}
