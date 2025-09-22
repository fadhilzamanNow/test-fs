<?php

namespace Database\Seeders;

use App\Models\PlanLog;
use Illuminate\Database\Seeder;

class PlanLogSeeder extends Seeder
{
    public function run(): void
    {
        PlanLog::factory(30)->create();
    }
}


