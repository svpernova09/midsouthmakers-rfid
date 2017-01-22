<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'key';

    public static $snakeAttributes = false;

    public function getDateCreatedAttribute($value)
    {
        return Carbon::createfromTimestamp((int)$value, 'America/Chicago');
    }

    public function getLastLoginAttribute($value)
    {
        return Carbon::createfromTimestamp((int)$value, 'America/Chicago');
    }
}
