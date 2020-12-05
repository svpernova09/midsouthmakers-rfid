<?php

use App\Tests\BrowserKitTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserIndexTest extends BrowserKitTest
{
    use DatabaseTransactions;

    public function testMembersRouteFromAdmin()
    {
        $user = factory(App\User::class)->create();
        $user->admin = true;
        $user->save();

        $this->actingAs($user)
            ->visit('/users')
            ->see($user->name)
            ->see($user->email)
            ->see($user->created_at);

        $this->assertResponseOk();
    }
}
