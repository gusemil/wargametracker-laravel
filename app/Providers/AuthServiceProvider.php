<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\PlayedMatch;
use App\Policies\PlayedMatchPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PlayedMatch::class => PlayedMatchPolicy::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $this->registerPolicies();
    }
}
