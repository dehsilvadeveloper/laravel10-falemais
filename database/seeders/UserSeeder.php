<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domain\User\Models\User;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = collect(config('users.default'));

        DB::beginTransaction();

        $plans->map(
            fn($value) => User::updateOrCreate(
                ['id' => $value['id']],
                $value
            )
        );

        DB::commit();
    }
}
