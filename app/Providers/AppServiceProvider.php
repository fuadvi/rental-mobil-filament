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

          if ((bool) env('HTTPS', true)) {
              $this->app['url']->forceScheme('https');
          } else {
              $this->app['url']->forceScheme('http');
          }

          // $this->app['request']->server->set('HTTPS', env('HTTPS'));

      //   Gate::before(function (User $user, string $ability) {
      //     return $user->isSuperAdmin() ? true: $this->logoutAndAbort();
      // });
    }
}
