<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    private function logoutAndAbort() {
      if (Auth::check())
      {
        Auth::logout();
      }
      abort(404);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();

        Gate::before(function (User $user, string $ability) {
          return $user->isSuperAdmin() ? true: $this->logoutAndAbort();
      });
    }
}
