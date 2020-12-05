<?php

namespace Database\Factories\Member;

use App\Model;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            'key' => $this->faker->numberBetween(0, 999999),
            'hash' => sha1('1111'),
            'spoken_name' => $this->faker->name,
            'irc_name' => $this->faker->name,
            'added_by' => $users->random()->id,
            'date_created' => Carbon\Carbon::now(),
            'last_login' => Carbon\Carbon::now(),
            'active' => 1,
            'admin' => 0,
        ];
    }
}
