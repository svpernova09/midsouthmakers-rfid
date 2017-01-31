<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function getDates()
    {
        return array('created_at', 'updated_at', 'last_login', 'date_created');
    }

    public function user()
    {
        return $this->belongsTo('\App\Member');
    }
}
