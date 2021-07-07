<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'password',
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function executeJobs()
    {
        return $this->hasMany(Job::class, 'execute_uid');
    }

    public function executeJobResumes()
    {
        return $this->hasManyThrough(Resume::class, Job::class, 'execute_uid');
    }

    public function uploadResumes()
    {
        // return $this->hasMany(Resume::class, 'upload_uid');
        return $this->belongsToMany(Resume::class)->wherePivot('type', 'upload')->withPivot('created_at')->withTimestamps();
    }

    public function seenResumes()
    {
        return $this->belongsToMany(Resume::class)->wherePivot('type', 'seen')->withPivot('created_at')->withTimestamps();
    }

    public function downloadResumes()
    {
        return $this->belongsToMany(Resume::class)->wherePivot('type', 'download')->withPivot('created_at')->withTimestamps();
    }

    public function getAvatarUrlAttribute()
    {
        $url = 'images/avatar_default.png';

        if (!empty($this->avatar)) {
            $url = Storage::disk('user_avatar')->url($this->attributes['avatar']);
        }

        return asset($url);
    }

    public function getBranchAttribute()
    {
        $rids = $this->roles->pluck('id');
        $roles = Role::branch($rids)->get();
        $udis = [];
        foreach ($roles as $role) {
            $udis = array_merge($udis, $role->users->pluck('id')->toArray());
        }

        return $udis;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('is_admin', '!=', true);
    }

    public function scopeBranch($query, $uids)
    {
        return $query->whereIn('id', $uids);
    }

    public function scopeSubordinate($query)
    {
        return $query->$this->roles()->where('parent_id', $this->id);
    }

    /**
     * Checks if User has access to $permission.
     */
    public function hasAccess($permission)
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if($role->hasAccess($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     */
    public function inRole($roleSlug, $rolesLevel)
    {
        return $this->roles()->where('slug', $roleSlug)->where('level', $rolesLevel)->count() == 1;
    }

    public function isSuperAdmin()
    {
        return $this->is_admin && $this->inRole('admin', 0);
    }
}
