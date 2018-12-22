<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Posts;
use \Spatie\Permission\Models\Role;
use App\Policies\PostsPolicy;
use App\Policies\RolesPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Posts::class => PostsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Gates for Posts
         */
        Gate::define('edit-post', 'App\Policies\PostPolicy@edit');
        Gate::define('delete-post', 'App\Policies\PostPolicy@delete');

        /**
         * Gates for Roles
         */
        Gate::define('manage-roles', 'App\Policies\RolePolicy@manageRoles');
    }
}
