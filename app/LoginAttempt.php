<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    public function member()
    {
        return $this->belongsTo('\App\Member', 'key', 'key');
    }
}
