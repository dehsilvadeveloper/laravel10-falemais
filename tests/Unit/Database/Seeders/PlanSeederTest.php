<?php

namespace Tests\Unit\Database\Seeders;

use Tests\TestCase;
use Database\Seeders\PlanSeeder;

class PlanSeederTest extends TestCase
{
    /**
     * @group seeders
     * @group plan
     */
    public function test_can_seed_plans_into_database(): void
    {
        $this->seed(PlanSeeder::class);

        foreach (config('plans.default') as $plan) {
            $this->assertDatabaseHas('plans', $plan);
        }
    }
}
