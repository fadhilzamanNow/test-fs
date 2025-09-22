<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPlanFactory extends Factory
{
    protected $model = ProductPlan::class;

    public function definition(): array
    {
        return [
            'plan_name'  => $this->faker->sentence(3),
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'status'     => 'pending',
            'due_date'   => $this->faker->dateTimeBetween('+3 days', '+1 month')->format('Y-m-d'),
            'created_at' => now(),
            'created_by' => \App\Models\User::inRandomOrder()->value('id') ?? \App\Models\User::factory(),
            'quantity' =>  random_int(1,20)
        ];
    }
}
