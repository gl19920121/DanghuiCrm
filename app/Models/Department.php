<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "department";
    protected $appends = ['admin_position'];

    public function position()
    {
        return $this->belongsToMany(Position::class, 'department_position', 'department_id', 'position_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'department_user', 'department_id', 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'pno', 'no');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'pno', 'no');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function getAdminPositionAttribute()
    {
        $positions = $this->position;
        $admin = null;
        $highestLevel = null;
        foreach ($positions as $position) {
            if ($highestLevel === null || $position->level < $highestLevel) {
                $highestLevel = $position->level;
                $admin = $position;
            }
        }

        return $admin;
    }
}
