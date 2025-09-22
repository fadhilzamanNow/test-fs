<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;
    public function definition(): array
    {

        $roleIds = DB::table("roles")->pluck("id");
        $moduleIds = DB::table("modules")->pluck("id");


        
        return [
            //
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make("password123"),
            "role_id" => $this->faker->randomElement($roleIds),
            "module_id" => $this->faker->randomElement($moduleIds),
            "created_at" => now()
        ];
    }
}
