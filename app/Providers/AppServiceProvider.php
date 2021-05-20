<?php

namespace App\Providers;

use App\Kreds;
use App\Observers\PageObserver;
use App\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Page::observe(PageObserver::class);

        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
        View::share('kredse_count', Kreds::isActive()->count());
        View::share('pages', Cache::rememberForever('pages', function () {
            return Page::all();
        }));
    }
}
