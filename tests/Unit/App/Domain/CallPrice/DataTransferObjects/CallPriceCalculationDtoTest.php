<?php

namespace Tests\Unit\App\Domain\CallPrice\DataTransferObjects\Eloquent;

use Tests\TestCase;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use Illuminate\Http\Request;
use App\Domain\CallPrice\DataTransferObjects\CallPriceCalculationDto;

class CallPriceCalculationDtoTest extends TestCase
{
    /**
     * @group dtos
     * @group callprice
     */
    public function test_can_create_from_array_with_snakecase_keys(): void
    {
        $data = [
            'call_minutes' => 40,
            'exceeding_fee_percentage' => 10,
            'fare_price_per_minute' => 1.90,
            'plan_max_free_minutes' => 30
        ];

        $dto = CallPriceCalculationDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceCalculationDto::class, $dto);
        $this->assertEquals($data['call_minutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($data['exceeding_fee_percentage'], $dtoAsArray['exceeding_fee_percentage']);
        $this->assertEquals($data['fare_price_per_minute'], $dtoAsArray['fare_price_per_minute']);
        $this->assertEquals($data['plan_max_free_minutes'], $dtoAsArray['plan_max_free_minutes']);
    }

    /**
     * @group dtos
     * @group callprice
     */
    public function test_can_create_from_array_with_camelcase_keys(): void
    {
        $data = [
            'callMinutes' => 40,
            'exceedingFeePercentage' => 10,
            'farePricePerMinute' => 1.90,
            'planMaxFreeMinutes' => 30
        ];

        $dto = CallPriceCalculationDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceCalculationDto::class, $dto);
        $this->assertEquals($data['callMinutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($data['exceedingFeePercentage'], $dtoAsArray['exceeding_fee_percentage']);
        $this->assertEquals($data['farePricePerMinute'], $dtoAsArray['fare_price_per_minute']);
        $this->assertEquals($data['planMaxFreeMinutes'], $dtoAsArray['plan_max_free_minutes']);
    }

    /**
     * @group dtos
     * @group callprice
     */
    public function test_cannot_create_from_empty_array(): void
    {
        $this->expectException(CannotCreateData::class);

        $dto = CallPriceCalculationDto::from([]);
    }

    /**
     * @group dtos
     * @group callprice
     */
    public function test_can_create_from_request(): void
    {
        $requestData = [
            'call_minutes' => 40,
            'exceeding_fee_percentage' => 10,
            'fare_price_per_minute' => 1.90,
            'plan_max_free_minutes' => 30
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = CallPriceCalculationDto::from($request);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceCalculationDto::class, $dto);
        $this->assertEquals($requestData['call_minutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($requestData['exceeding_fee_percentage'], $dtoAsArray['exceeding_fee_percentage']);
        $this->assertEquals($requestData['fare_price_per_minute'], $dtoAsArray['fare_price_per_minute']);
        $this->assertEquals($requestData['plan_max_free_minutes'], $dtoAsArray['plan_max_free_minutes']);
    }

    /**
     * @group dtos
     * @group callprice
     */
    public function test_cannot_create_from_empty_request(): void
    {
        $this->expectException(CannotCreateData::class);

        $request = Request::create('/dummy', 'POST', []);

        $dto = CallPriceCalculationDto::from([]);
    }
}
