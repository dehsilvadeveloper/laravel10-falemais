<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Fare\Models\Fare;

class FareFactory extends Factory
{
    protected $model = Fare::class;

    public function definition(): array
    {
        return [
            'ddd_origin' => str_pad($this->faker->areaCode(), 3, '0', STR_PAD_LEFT),
            'ddd_destination' => str_pad($this->faker->areaCode(), 3, '0', STR_PAD_LEFT),
            'price_per_minute' => $this->faker->randomFloat(2, 1, 9999.99)
        ];
    }
}
