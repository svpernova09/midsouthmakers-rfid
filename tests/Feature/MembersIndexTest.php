<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
            ->get('/members')
            ->see($member->key)
            ->see($member->irc_name)
            ->see($member->spoken_name);

        $this->assertResponseOk();
    }

    public function testMembersRouteFromUser()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->get('/members')
            ->seePageIs('/');
    }

}
