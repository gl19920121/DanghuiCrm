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

    public function department()
    {
        return $this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id');
    }

    public function position()
    {
        return $this->belongsToMany(Position::class, 'position_user', 'user_id', 'position_id');
    }

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

    public function isDepartment($no)
    {
        return $this->department->contains(Department::where('no', $no)->first());
    }

    public function isBelongToDepartment($dno)
    {
        $isBelongTo = false;
        $departments = $this->department;

        foreach ($departments as $department) {
            $item = Department::with('parentRecursive')->find($department->id);

            while (!empty($item)) {
                if ($item->no === $dno) {
                    $isBelongTo = true;
                    break 2;
                }

                $item = $item->parentRecursive;
            }
        }

        return $isBelongTo;
    }

    public function isDepartmentAdmin($department = null)
    {
        // 特殊处理
        if (in_array($this->id, [11, 12])) { // 李萍萍,严瑾婧
            return true;
        }
        if ($this->id === 6 && $this->department->contains(Department::where('no', 'N000003')->first())) { // 支宪璐
            return true;
        }

        $isAdmin = false;
        $departments = empty($department) ? $this->department : array($department);

        foreach ($departments as $item) {
            if (in_array($item->admin_position->id, Auth::user()->position->pluck('id')->toArray())) {
                $isAdmin = true;
                break;
            }
        }

        return $isAdmin;
    }

    public function isSuperAdmin()
    {
        return $this->is_admin;
    }
}
