<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domain\Plan\Models\Plan;

class PlanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = collect(config('plans.default'));

        DB::beginTransaction();

        $plans->map(
            fn($value) => Plan::updateOrCreate(
                ['id' => $value['id']],
                $value
            )
        );

        DB::commit();
    }
}
