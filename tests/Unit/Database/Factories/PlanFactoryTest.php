<?php

namespace Tests\Unit\Database\Factories;

use Tests\TestCase;
use App\Domain\Plan\Models\Plan;

class PlanFactoryTest extends TestCase
{
    /**
     * @group factories
     * @group plan
     */
    public function test_can_create_a_plan_model(): void
    {
        $plan = Plan::factory()->make();

        $this->assertInstanceOf(Plan::class, $plan);
    }
}
