<?php

namespace App\Providers;

use App\Models\Cms\User\Permission;
use App\Models\Cms\User\PermissionRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
        if(\Schema::hasTable('permissions')){
            if(count(Permission::all()) && count(PermissionRole::all())){
                foreach ($this->getPermissions() as $permission) {
                    $gate->before(function ($user, $ability) {
                        if($user->isArchitect()) {
                            return true;
                        }
                    });
                    $gate->define($permission->name, function ($user) use ($permission) {
                        return $user->hasPermission($permission);
                    });
                }
            }
        }
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
