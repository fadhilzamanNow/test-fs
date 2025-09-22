<?php

namespace Database\Factories;

use App\Models\PlanLog;
use App\Models\ProductPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanLogFactory extends Factory
{
    protected $model = PlanLog::class;

    public function definition(): array
    {
        $statuses = ['pending','approved','rejected'];
        $from     = $this->faker->randomElement($statuses);
        $to       = $this->faker->randomElement(array_diff($statuses, [$from]));

        return [
            'plan_id'     => ProductPlan::inRandomOrder()->value('id') ?? ProductPlan::factory(),
            'from_status' => $from,
            'to_status'   => $to,
            'changed_by'  => User::inRandomOrder()->value('id') ?? null,
            'note'        => $this->faker->sentence(),
            'created_at'  => now(),
        ];
    }
}

