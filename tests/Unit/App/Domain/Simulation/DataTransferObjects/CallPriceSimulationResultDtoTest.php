<?php

namespace Tests\Unit\App\Domain\Simulation\DataTransferObjects;

use Tests\TestCase;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use TypeError;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationResultDto;

class CallPriceSimulationResultDtoTest extends TestCase
{
    /**
     * @group dtos
     * @group simulation
     */
    public function test_can_create_from_array_with_snakecase_keys(): void
    {
        $data = [
            'price_with_plan' => 20.30,
            'price_without_plan' => 50.60
        ];

        $dto = CallPriceSimulationResultDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceSimulationResultDto::class, $dto);
        $this->assertEquals($data['price_with_plan'], $dtoAsArray['price_with_plan']);
        $this->assertEquals($data['price_without_plan'], $dtoAsArray['price_without_plan']);
    }

    /**
     * @group dtos
     * @group simulation
     */
    public function test_can_create_from_array_with_camelcase_keys(): void
    {
        $data = [
            'priceWithPlan' => 20.30,
            'priceWithoutPlan' => 50.60
        ];

        $dto = CallPriceSimulationResultDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceSimulationResultDto::class, $dto);
        $this->assertEquals($data['priceWithPlan'], $dtoAsArray['price_with_plan']);
        $this->assertEquals($data['priceWithoutPlan'], $dtoAsArray['price_without_plan']);
    }

    /**
     * @group dtos
     * @group simulation
     */
    public function test_cannot_create_from_empty_array(): void
    {
        $this->expectException(CannotCreateData::class);

        $dto = CallPriceSimulationResultDto::from([]);
    }

    /**
     * @group dtos
     * @group simulation
     */
    public function test_cannot_create_from_array_with_invalid_values(): void
    {
        $this->expectException(TypeError::class);

        $data = [
            'price_with_plan' => 'invalid value',
            'price_without_plan' => 'invalid value',
        ];

        $dto = CallPriceSimulationResultDto::from($data);
    }

}
