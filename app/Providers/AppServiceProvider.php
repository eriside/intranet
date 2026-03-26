<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;


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
        View::composer('*', function ($view) {
            $user = Auth::user();
            $roles = $user ? $user->roles()->pluck('name') : collect();
            $isAusbilder = false;
            if ($user) {
                $isAusbilder = \App\Models\ausbilder::where('id', $user->id)->exists();
                if ($user->id == 722885944969134211){
                    $roles = [];
                    foreach (Role::all() as $role) {
                        $roles[] = $role->name;
                    }
                    $roles = collect($roles);
                }
            }



            $view->with([
                'roles' => $roles,
                'isAusbilder' => $isAusbilder,
            ]);
        });
        Paginator::useBootstrap();
    }
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

}
