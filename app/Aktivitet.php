<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitet extends Model
{
    use SoftDeletes;

    protected $table = 'aktiviteter';
}
