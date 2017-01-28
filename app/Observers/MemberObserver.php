<?php

namespace App\Observers;

use App\Member;

class MemberObserver
{
    /**
     * Listen to the Member created event.
     *
     * @param  Member  $member
     * @return void
     */
    public function saved(Member $member)
    {
        \Cache::forget('members');
    }

    /**
     * Listen to the Member deleting event.
     *
     * @param  Member  $member
     * @return void
     */
    public function deleted(Member $member)
    {
        \Cache::forget('members');
    }
}