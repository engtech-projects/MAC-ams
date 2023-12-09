<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */

    protected $user;
    protected $userAccess;
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function boot()
    {
        $this->checkGate();
        $this->registerPolicies();
    }

    protected function checkGate()
    {
        Gate::define('branch-manager', function (User $user) {
            return $user->userRole->role_name === UserRole::BRANCH_MANAGER_ROLE ? true : false;
        });
    }
}
