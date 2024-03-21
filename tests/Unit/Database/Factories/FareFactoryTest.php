<?php

namespace Tests\Unit\Database\Factories;

use Tests\TestCase;
use App\Domain\Fare\Models\Fare;

class FareFactoryTest extends TestCase
{
    /**
     * @group factories
     * @group fare
     */
    public function test_can_create_a_fare_model(): void
    {
        $fare = Fare::factory()->make();

        $this->assertInstanceOf(Fare::class, $fare);
    }
}
