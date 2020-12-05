<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function getDates()
    {
        return ['created_at', 'updated_at', 'last_login', 'date_created'];
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function logins()
    {
        return $this->hasMany(\App\LoginAttempt::class, 'key', 'key');
    }

    public function getLastLoginRecordAttribute()
    {
        return $this->logins->first()->orderBy('timestamp', 'desc')->limit(1)->first()->timestamp;
    }
}
