<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    protected $casts = [
        'level' => 'integer',
    ];
    protected $hidden = [];
    protected $appends = ['relation'];

    public function getRelationAttribute()
    {
        // $relation = [$this];
        $relation = collect([$this]);

        $pno = $this->pno;
        while (!empty($pno)) {
            $parent = self::where('no', $pno)->first();
            // array_unshift($relation, $parent);
            $relation->prepend($parent);
            $pno = $parent->pno;
        }

        return $relation;
    }

    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}
