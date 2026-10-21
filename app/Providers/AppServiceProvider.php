<?php

namespace App\Providers;

use App\Models\Kreds;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        // Resolved lazily so artisan commands don't need a database connection.
        View::composer('layouts.app', function ($view) {
            $view->with('kredse_count', Kreds::isActive()->count());
            // Cached as plain arrays: Laravel refuses to unserialize objects from the cache.
            $pages = Cache::rememberForever('pages', fn () => Page::all(['navn', 'slug'])->toArray());
            $view->with('pages', array_map(fn (array $page) => (object) $page, $pages));
        });
    }
}
