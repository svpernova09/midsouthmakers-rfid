<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class MembersIndexTest extends TestCase
{
    use DatabaseTransactions;

    public function testMembersRouteFromAdmin()
    {
        $member = factory(App\Member::class)->create();
        $user = factory(App\User::class)->create();
        $user->admin = true;
        $user->save();


        $this->actingAs($user)
            ->visit('/members')
            ->see($member->key)
            ->see($member->ircName)
            ->see($member->spokenName);

        $this->assertResponseOk();
    }

    public function testMembersRouteFromUser()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/members')
            ->seePageIs('/');
    }

}
