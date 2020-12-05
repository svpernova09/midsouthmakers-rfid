<?php

use App\Member;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testMembersEndpoint()
    {

        $members = Member::factory(5)->create();
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();
        Cache::forget('members');
        $response = $this->json('GET', '/api/members', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'timestamp' => true,
                'members'   => true,
            ]);
    }

    public function testMemberGet()
    {
        $member = Member::factory()->create();
        $response = $this->json('GET', '/api/members/'.$member->id, []);

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
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/'.$user->id, []);

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
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/login-attempt', [
            'key'       => '123241234',
            'timestamp' => Carbon::now()->timestamp,
            'reason'    => 'Bad Key',
            'result'    => 'failure',
        ]);

        $response->assertStatus(422);
    }

    public function testLoginSuccessAttempt()
    {
        $user = User::factory()->create();
        $member = \App\Member::factory()->create();
        $user->admin = true;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/login-attempt', [
            'key'       => $member->key,
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

    public function testPassportOauthScopRouteForAdminNonAdmin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('GET', '/oauth/scopes', []);
        $response->assertStatus(200);
    }

    public function testPassportOuathScopRouteForAdmin()
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $response = $this->actingAs($user, 'api')->json('GET', '/oauth/scopes', []);
        $response->assertStatus(200);
    }
}
