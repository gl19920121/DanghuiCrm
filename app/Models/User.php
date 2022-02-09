<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;

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

    protected $appends = ['rolesChildren', 'children'];

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
        return $this->hasMany(Resume::class, 'upload_uid');
        // return $this->belongsToMany(Resume::class)->wherePivot('type', 'upload')->withPivot('created_at')->withTimestamps();
    }

    public function uploadWeekResumes()
    {
        return $this->hasMany(Resume::class, 'upload_uid')->where('resumes.created_at', '>=', Carbon::now()->startOfWeek());
    }

    public function uploadMonthResumes()
    {
        return $this->hasMany(Resume::class, 'upload_uid')->where('resumes.created_at', '>=', Carbon::now()->startOfMonth());
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

    public function getGroupUsers()
    {
        $users = collect();

        foreach (Auth::user()->roles as $role) {
            $key = $role->slug;
            if (empty($role->parentRecursive)) {
                $group = self::getChildrenUser($role->childrenRecursive);
            } else {
                $group = self::getChildrenUser([$role]);
            }

            $users = $users->merge(Array($key => $group));
        }

        return $users;
    }

    public function getRolesChildrenAttribute()
    {
        return self::getRolesChildren($this->roles);
    }

    public function getChildrenAttribute()
    {
        return self::getChildrenUser($this->roles);
    }

    private function getRolesChildren($roles)
    {
        $users = collect();

        foreach ($roles as $role) {
            if (in_array($role->level, $this->roles->pluck('level')->toArray())) {
                $roleUsers = $role->users->filter(function ($user, $index) {
                    return $user->id === $this->id;
                });
            } else {
                $roleUsers = $role->users;
            }

            if ($roleUsers->count() > 0) {
                $users = $users->merge(array($role->slug => $roleUsers));
            }

            if ($role->childrenRecursive->count() > 0) {
                $users = $users->merge(array($role->slug, self::getChildrenUser($role->childrenRecursive)));
            }
        }

        return $users;
    }

    private function getChildrenUser($roles)
    {
        $users = collect();

        foreach ($roles as $role) {
            if (in_array($role->level, $this->roles->pluck('level')->toArray())) {
                $roleUsers = $role->users->filter(function ($user, $index) {
                    return $user->id === $this->id;
                });
            } else {
                $roleUsers = $role->users;
            }

            if ($roleUsers->count() > 0) {
                $users = $users->merge($roleUsers);
            }

            if ($role->childrenRecursive->count() > 0) {
                $users = $users->merge(self::getChildrenUser($role->childrenRecursive));
            }
        }

        return $users;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('is_admin', '!=', true);
    }

    public function scopeChildren($query)
    {
        $uids = Auth::user()->children->pluck('id')->toArray();
        return $query->whereIn('id', $uids);
    }

    public function scopeSubordinate($query)
    {
        return $query->$this->roles()->where('parent_id', $this->id);
    }

    public function scopeRole($query, $role)
    {
        return $query->$this->roles()->where('sulg', 'like', $role . '%');
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
        // return $this->roles()->where('slug', $roleSlug)->orWhere('level', $rolesLevel)->count() > 0;
    }

    public function isSuperAdmin()
    {
        return $this->is_admin && $this->inRole('admin', 0);
    }
}
