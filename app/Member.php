<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'key';

    // no auto incrementing the PK
    public $incrementing = false;

    // because we have camel case columns
    public static $snakeAttributes = false;

    // because we don't have created/updated cols
    public $timestamps = false;

    // Convert to Carbon
    public function getDateCreatedAttribute($value)
    {
        return Carbon::createfromTimestamp((int)$value, 'America/Chicago');
    }

    // Convert to Carbon
    public function getLastLoginAttribute($value)
    {
        return Carbon::createfromTimestamp((int)$value, 'America/Chicago');
    }
}
