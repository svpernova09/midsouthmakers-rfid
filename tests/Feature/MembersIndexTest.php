<?php

use App\Tests\BrowserKitTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MembersIndexTest extends BrowserKitTest
{
    use DatabaseTransactions;

    public function testMembersRouteFromAdmin()
    {
        $member = \App\Member::factory()->create();
        $user = \App\User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members')
            ->see($member->key)
            ->see($member->irc_name)
            ->see($member->spoken_name);

        $this->assertResponseOk();
    }

    public function testMembersRouteFromUser()
    {
        $user = \App\User::factory()->create();

        $this->actingAs($user)
            ->visit('/members')
            ->seePageIs('/');
    }
}
