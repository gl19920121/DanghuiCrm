<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Resume;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResumePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function update(User $user, Resume $resume)
    {
        return $user->id === $resume->upload_uid;
    }

    public function destroy(User $user, Resume $resume)
    {
        return $user->id === $resume->upload_uid;
    }
}
