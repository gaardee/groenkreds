<?php

namespace App\Models;

use App\Observers\PageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PageObserver::class)]
class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
