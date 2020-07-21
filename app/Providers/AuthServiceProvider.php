<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GatePolice;

use App\User;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GatePolice $gate)
    {
        $this->registerPolicies($gate);

        $permissions = Permission::with('roles')->get();
        foreach( $permissions as $permission )
        {
            $gate->define($permission->slug, function(User $user) use ($permission){
                return $user->hasPermission($permission);
            });
        }

        $gate->before(function(User $user, $ability){

            if ( $user->hasAnyRoles('admin') )
                return true;

        });
    }
}
