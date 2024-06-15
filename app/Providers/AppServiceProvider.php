<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('admin', function (User $user){

          return $user->type == "A" ? true : false;
        });

        Gate::define('customer', function (User $user){

            return $user->type == "C" ? true : false;
        });
        // View::share adds data (variables) that are shared through all views (like global data)

        try{
            View::share('courses', Course::all());
        }catch(\Exception $e){

        }

    }
}
