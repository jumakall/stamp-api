<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        Gate::policy(\App\Pass::class, \App\Policies\PassPolicy::class);

        $this->app['auth']->viaRequest('api', function ($request) {
            $api_token = $request->hasHeader('Authorization') ?
                            substr($request->header('Authorization'), 7) :
                            $request->input('api_token');


            if ($api_token) {
                return User::where('api_token', $api_token)->first();
            }
        });
    }
}
