<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitet extends Model
{
    use SoftDeletes;

    public const TYPES = [
        1 => 'Kredsen i lokalmiljøet',
        2 => 'Kredsens levevej',
        3 => 'Den legende kreds',
    ];

    public const TYPE_COLORS = [
        1 => '#289438',
        2 => '#EC6411',
        3 => '#FBB800',
    ];

    protected $table = 'aktiviteter';

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function kredse(): BelongsToMany
    {
        return $this->belongsToMany(Kreds::class);
    }
}
