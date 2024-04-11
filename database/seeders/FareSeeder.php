<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domain\Fare\Models\Fare;

class FareSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = collect(config('fares.default'));

        DB::beginTransaction();

        $plans->map(
            fn($value) => Fare::updateOrCreate(
                ['id' => $value['id']],
                $value
            )
        );

        DB::commit();
    }
}
