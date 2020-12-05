<?php

namespace App\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberConnectTest extends BrowserKitTest
{
    use DatabaseTransactions;

    public function testUserCanConnectMember()
    {
        $user = \App\User::factory()->create();
        $member = \App\Member::factory()->create();

        $this->actingAs($user)
            ->visit('/member-connect')
            ->type($member->key, 'key')
            ->type('1111', 'pin')
            ->press('Submit')
            ->seePageIs('/home')
            ->see($member->spoken_name)
            ->see($member->irc_name)
            ->see($member->key);
    }

    public function testFieldsAreRequired()
    {
        $user = \App\User::factory()->create();

        $this->actingAs($user)
            ->visit('/member-connect')
            ->type('', 'key')
            ->type('', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('The key field is required')
            ->see('The pin field is required');
    }

    public function testKeyAlreadyConnected()
    {
        $user = \App\User::factory()->create();
        $member = \App\Member::factory()->create();
        $member->user_id = $user->id;
        $member->save();

        $this->actingAs($user)
            ->visit('/member-connect')
            ->type($member->key, 'key')
            ->type('1111', 'pin')
            ->press('Submit')
            ->visit('/member-connect')
            ->type($member->key, 'key')
            ->type('1111', 'pin')
            ->press('Submit')
            ->see('Key has already been connected');
    }

    public function testKeyCannotBeConnect()
    {
        $user = \App\User::factory()->create();
        $member = \App\Member::factory()->create();

        $this->actingAs($user)
            ->visit('/member-connect')
            ->type($member->key, 'key')
            ->type('2222', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('Could not connect that key.');
    }

    public function testPreventBruteForce()
    {
        $user = \App\User::factory()->create();
        $member = \App\Member::factory()->create();

        $this->actingAs($user)
            ->visit('/member-connect')
            ->type($member->key, 'key')
            ->type('2222', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('Could not connect that key.')
            ->type($member->key, 'key')
            ->type('2222', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('Could not connect that key.')
            ->type($member->key, 'key')
            ->type('2222', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('Could not connect that key.')
            ->type($member->key, 'key')
            ->type('2222', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('Could not connect that key.')
            ->type($member->key, 'key')
            ->type('2222', 'pin')
            ->press('Submit')
            ->seePageIs('/member-connect')
            ->see('Could not connect that key.');
    }
}
