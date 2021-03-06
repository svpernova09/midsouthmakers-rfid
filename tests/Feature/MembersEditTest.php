<?php

use App\Tests\BrowserKitTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MembersEditTest extends BrowserKitTest
{
    use DatabaseTransactions;

    public function testMemberCanBeEdited()
    {
        $member = \App\Member::factory()->create();
        $user = \App\User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members/'.$member->id.'/edit')
            ->type('IRC Name', 'irc_name')
            ->type('Name', 'spoken_name')
            ->select(true, 'admin')
            ->select(true, 'active')
            ->press('Submit')
            ->seePageIs('/members')
            ->see('IRC name')
            ->see('Name')
            ->see($member->key);
    }

    public function testFieldsAreRequired()
    {
        $member = \App\Member::factory()->create();
        $user = \App\User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/members/'.$member->id.'/edit')
            ->type('', 'irc_name')
            ->type('', 'spoken_name')
            ->press('Submit')
            ->seePageIs('/members/'.$member->id.'/edit')
            ->see('The irc name field is required')
            ->see('The spoken name field is required');
    }

    public function testMemberPinCanBeEdited()
    {
        $member = \App\Member::factory()->create();
        $user = \App\User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
             ->visit('/members/'.$member->id.'/edit')
             ->type('IRC Name', 'irc_name')
             ->type('Name', 'spoken_name')
             ->type('2222', 'pin')
             ->select(true, 'admin')
             ->select(true, 'active')
             ->press('Submit')
             ->seePageIs('/members')
             ->see('IRC name')
             ->see('Name')
             ->see($member->key)
            ->assertViewMissing('error');
    }
}
