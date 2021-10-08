<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Resume::class => \App\Policies\ResumePolicy::class,
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
        Gate::define('user-status', function ($user) {
            return $user->status === 1;
        });
        Gate::define('rpo-manager', function ($user) {
            return $user->inRole('rpo', 1) || $user->inRole('ceo', 0);
        });
        Gate::define('rpo-manager-audit', function ($user) {
            return $user->inRole('rpo', 1);
        });
        Gate::define('job-not-need-check', function ($user) {
            return $user->inRole('rpo', 1);
        });
    }
}
