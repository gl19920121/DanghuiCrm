<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\Resume;
use App\Policies\ResumePolicy;
use App\Models\Article;
use App\Policies\ArticlePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Resume::class => ResumePolicy::class,
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // Gate
        Gate::define('rpo-manager', function ($user) {
            return ($user->isBelongToDepartment('N0001') && $user->isDepartmentAdmin()) || $user->isDepartment('N01');
        });
        Gate::define('rpo-manager-audit', function ($user) {
            return $user->isBelongToDepartment('N0001') && $user->isDepartmentAdmin();
        });
        Gate::define('job-not-need-check', function ($user) {
            return $user->isDepartmentAdmin();
        });
        Gate::define('statistics', function ($user) {
            return $user->id === 2;
        });
        Gate::define('article-publish', function ($user) {
            return $user->isBelongToDepartment('N000006');
        });
    }
}
