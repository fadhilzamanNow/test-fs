<?php

namespace Database\Seeders;

use App\Models\ProductPlan;
use App\Models\PlanLog;
use Illuminate\Database\Seeder;

class ProductPlanSeeder extends Seeder
{
    public function run(): void
    {
        ProductPlan::factory(10)
            ->has(PlanLog::factory()->count(1), 'statusLogs')
            ->create();
    }
}
