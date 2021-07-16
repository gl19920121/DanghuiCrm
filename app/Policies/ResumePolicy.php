<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Resume;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResumePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function update(User $currentUser, Resume $resume)
    {
        return $currentUser->is_admin || $currentUser->id === $resume->upload_uid;
    }

    public function destroy(User $currentUser, Resume $resume)
    {
        return $currentUser->is_admin || $currentUser->id === $resume->upload_uid;
    }
}
