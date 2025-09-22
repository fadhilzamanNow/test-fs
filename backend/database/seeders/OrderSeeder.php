<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\ProductPlan;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $plans = ProductPlan::inRandomOrder()->take(5)->get();

        foreach ($plans as $plan) {
            Order::create([
                'plan_id'    => $plan->id,
                'status'     => 'waiting',
                'due_date'   => now()->addDays(7),
                'created_at' => now()
            ]);
        }
    }
}

