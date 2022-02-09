<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $casts = [
        'permissions' => 'array'
    ];

    protected $appends = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id')->where('status', '>', 0);
    }

    // public function usersJobs()
    // {
    //     return $this->hasManyThrough(Job::class, User::class, 'execute_uid');
    // }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function scopeBranch($query, $rids)
    {
        return $query->whereIn('parent_id', $rids);
    }

    public function hasAccess($permission)
    {
        return $this->hasPermission($permission);
    }

    private function hasPermission($permission)
    {
        return isset($this->permissions[$permission]) ? $this->permissions[$permission] : false;
    }
}
