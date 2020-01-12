<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitet extends Model
{
    use SoftDeletes;

    protected $table = 'aktiviteter';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function kredse()
    {
        return $this->belongsToMany('App\Kreds');
    }
}
