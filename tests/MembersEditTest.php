<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class MembersEditTest extends TestCase
{
//    use DatabaseTransactions;

    public function testMemberCanBeEdited()
    {
        $member = factory(App\Member::class)->create();
        $user = factory(App\User::class)->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members/' . $member->key . '/edit')
            ->type('IRC Name', 'ircName')
            ->type('Name', 'spokenName')
            ->select(true, 'isAdmin')
            ->select(true, 'isActive')
            ->press('Submit')
            ->seePageIs('/members')
            ->see('IRC name')
            ->see('Name')
            ->see($member->key);

    }

    public function testFieldsAreRequired()
    {
        $member = factory(App\Member::class)->create();
        $user = factory(App\User::class)->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members/' . $member->key . '/edit')
            ->type('', 'ircName')
            ->type('', 'spokenName')
            ->press('Submit')
            ->seePageIs('/members/' . $member->key . '/edit')
            ->see('The irc name field is required')
            ->see('The spoken name field is required');
    }

}
