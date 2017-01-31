<?php

use App\Tests\BrowserKitTest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MembersCreateTest extends BrowserKitTest
{
    use DatabaseTransactions;

    public function testMemberCanBeCreated()
    {
        $user = factory(App\User::class)->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members/create')
            ->type('123456', 'key')
            ->type('1111', 'pin')
            ->type('New Member', 'irc_name')
            ->type('New Member Name', 'spoken_name')
            ->select(true, 'admin')
            ->select(true, 'active')
            ->press('Submit')
            ->seePageIs('/members')
            ->see('New Member')
            ->see('New Member Name');
    }

    public function testFieldsAreRequired()
    {
        $user = factory(App\User::class)->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members/create')
            ->type('', 'key')
            ->type('', 'pin')
            ->type('', 'irc_name')
            ->type('', 'spoken_name')
            ->press('Submit')
            ->seePageIs('/members/create')
            ->see('The key field is required')
            ->see('The pin field is required')
            ->see('The irc name field is required')
            ->see('The spoken name field is required');
    }

}
