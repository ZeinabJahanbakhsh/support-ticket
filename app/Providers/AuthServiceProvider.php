<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
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
        // 'App\Models\Comment' => CommentPolicy::class

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

    }


}
