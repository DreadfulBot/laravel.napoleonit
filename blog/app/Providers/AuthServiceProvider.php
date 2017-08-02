<?php

namespace App\Providers;

use App\Category;
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

        Gate::define('user.create', function($user) {
            /* @var \App\User $user */
            return $user->hasAccess(['user.create']);
        });

        Gate::define('user.update', function($executor, User $user) {
            //if($executor->id == $user->id)
            //    return true;

            /* @var \App\User $executor */
            return $executor->hasAccess(['user.update']);
        });

        Gate::define('user.delete', function($executor, User $user) {
            // admin must live
            if($user->id == 1)
                return false;
            //if($executor->id == $user->id)
            //    return true;

            /* @var \App\User $executor */
            return $executor->hasAccess(['user.delete']);
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

        Gate::define('category.delete', function($user, Category $category) {
            // category empty must be in safe
            if($category->id == 1)
                return false;

            /* @var \App\User $user */
            return $user->hasAccess(['category.delete']);
        });

        Gate::define('category.update', function($user, Category $category) {
            /* @var \App\User $user */
            return $user->hasAccess(['category.update']);
        });
    }

    public function registerArticlePolices() {
        Gate::define('article.list', function($user) {
            /* @var \App\User $user */
            return $user->hasAccess(['article.list']);
        });
    }
}
