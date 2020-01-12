<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kreds extends Model
{
    use SoftDeletes;

    protected $table = 'kredse';

    protected $fillable = [
        'id',
        'key',
        'navn',
        'website',
        'stednavn',
        'adresse',
        'postnr',
        'bynavn',
        'latitude',
        'longitude',
        'kontakt_navn',
        'kontakt_email',
        'kontakt_telefon',
    ];

    protected $casts = [
        'billeder' => 'array'
    ];

    protected $with = ['aktiviteter'];

    public function scopeHasCoordinates($query)
    {
        return $query->where('latitude', '!=', 0)->where('longitude', '!=', 0);
    }

    public function scopeIsActive($query)
    {
        return $query->where('active', true)->hasCoordinates();
    }

    public function aktiviteter()
    {
        return $this->belongsToMany('App\Aktivitet')->orderBy('type');
    }
}
