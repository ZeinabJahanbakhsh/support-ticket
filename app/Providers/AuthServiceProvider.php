<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enums\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Ticket' => TicketPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //$this->registerPolicies();

        \Gate::define('index-tickets', function (User $user){
            $userRole = $user->roles->toArray();
            return $userRole[0]['code'] == RoleEnum::admin->value;
        });

    }
}
