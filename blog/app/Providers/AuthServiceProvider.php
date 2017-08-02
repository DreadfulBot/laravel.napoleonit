<?php

namespace App\Providers;

use App\User;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerUserPolices();
        $this->registerCategoryPolices();
        $this->registerArticlePolices();
        //
    }

    public function registerUserPolices() {
        Gate::define('user.list', function($user) {
            /* @var \App\User $user */
            return $user->hasAccess(['user.list']);
        });
    }

    public function registerCategoryPolices() {
        Gate::define('category.list', function($user) {
            /* @var \App\User $user */
            return $user->hasAccess(['category.list']);
        });

        Gate::define('category.create', function($user) {
            /* @var \App\User $user */
            return $user->hasAccess(['category.create']);
        });
    }

    public function registerArticlePolices() {
        Gate::define('article.list', function($user) {
            /* @var \App\User $user */
            return $user->hasAccess(['article.list']);
        });
    }
}
