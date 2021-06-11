<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $casts = [
        'permissions' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
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
