<?php

namespace Tests\Unit\Database\Seeders;

use Tests\TestCase;
use Database\Seeders\FareSeeder;

class FareSeederTest extends TestCase
{
    /**
     * @group seeders
     * @group fare
     */
    public function test_can_seed_fares_into_database(): void
    {
        $this->seed(FareSeeder::class);

        foreach (config('fares.default') as $fare) {
            $this->assertDatabaseHas('fares', $fare);
        }
    }
}
