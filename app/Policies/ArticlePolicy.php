<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin || $user->isDepartmentAdmin('N000006')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the article.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isBelongToDepartment('N000006');
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isBelongToDepartment('N000006');
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->publisher_id;
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->publisher_id;
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
