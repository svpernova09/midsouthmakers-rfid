<?php

namespace App;

use Carbon\Carbon;
use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function fillable(array $fillable)
    {
        return [
            'key',
            'hash',
            'irc_name',
            'spoken_name',
            'added_by',
            'date_created',
            'last_login',
            'admin',
            'active',
            'user_id',
        ];
    }

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

    protected static function newFactory()
    {
        return MemberFactory::new();
    }
}
