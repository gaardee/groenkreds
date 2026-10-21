<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kreds extends Model
{
    use SoftDeletes;

    protected $table = 'kredse';

    protected $fillable = [
        'id',
        'key',
        'active',
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
        'active' => 'boolean',
        'billeder' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected $with = ['aktiviteter'];

    public function scopeHasCoordinates(Builder $query): Builder
    {
        return $query->where('latitude', '!=', 0)->where('longitude', '!=', 0);
    }

    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('active', true)->hasCoordinates();
    }

    public function aktiviteter(): BelongsToMany
    {
        return $this->belongsToMany(Aktivitet::class)->orderBy('type');
    }
}
