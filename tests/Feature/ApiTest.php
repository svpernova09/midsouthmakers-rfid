<?php

use App\Member;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->user->admin = true;
        $this->user->save();
    }

    public function testMembersEndpoint()
    {
        $response = $this->actingAs($this->user, 'api')->json('GET', '/api/members', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'timestamp' => true,
                'members'   => true,
            ]);
    }

    public function testMemberGet()
    {
        $member = factory(Member::class)->create();

        $response = $this->actingAs($this->user, 'api')->json('GET', '/api/members/' . $member->id, []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id'          => $member->id,
                'key'         => $member->key,
                'irc_name'    => $member->irc_name,
                'spoken_name' => $member->spoken_name,
                'added_by'    => $member->added_by,
                'admin'       => $member->admin,
                'active'      => $member->active,
            ]);
    }

    public function testUserGet()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->user, 'api')->json('GET', '/api/users/' . $user->id, []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'admin' => $user->admin,
            ]);
    }

    public function testLoginFailedAttempt()
    {
        $response = $this->actingAs($this->user, 'api')->json('POST', '/api/login-attempt', [
            'key'       => '123241234',
            'timestamp' => Carbon::now()->timestamp,
            'reason'    => 'Bad Key',
            'result'    => 'failure',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function testLoginSuccessAttempt()
    {
        $response = $this->actingAs($this->user, 'api')->json('POST', '/api/login-attempt', [
            'key'       => '12314234',
            'timestamp' => Carbon::now()->timestamp,
            'reason'    => 'success',
            'result'    => 'success',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

}