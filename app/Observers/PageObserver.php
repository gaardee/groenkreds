<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class PageObserver
{
    /**
     * Handle the Page "created" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function created()
    {
        Cache::forget('pages');
    }

    /**
     * Handle the Page "updated" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function updated()
    {
        Cache::forget('pages');
    }

    /**
     * Handle the Page "deleted" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function deleted()
    {
        Cache::forget('pages');
    }

    /**
     * Handle the Page "forceDeleted" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function forceDeleted()
    {
        Cache::forget('pages');
    }
}
