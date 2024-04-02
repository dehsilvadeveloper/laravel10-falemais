<?php

namespace Tests\Unit\App\Domain\CallPrice\DataTransferObjects;

use Tests\TestCase;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use TypeError;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
    public function test_can_create_from_array_using_default_exceeding_fee_percentage(): void
    {
        $exceedingFeePercentage = 5;

        config()->set('callprice.configuration.exceeding_fee_percentage', $exceedingFeePercentage);

        $data = [
            'call_minutes' => 40,
            'fare_price_per_minute' => 1.90,
            'plan_max_free_minutes' => 30
        ];

        $dto = CallPriceCalculationDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceCalculationDto::class, $dto);
        $this->assertEquals($data['call_minutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($exceedingFeePercentage, $dtoAsArray['exceeding_fee_percentage']);
        $this->assertEquals($data['fare_price_per_minute'], $dtoAsArray['fare_price_per_minute']);
        $this->assertEquals($data['plan_max_free_minutes'], $dtoAsArray['plan_max_free_minutes']);
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
    public function test_cannot_create_from_array_with_invalid_values(): void
    {
        $this->expectException(TypeError::class);

        $data = [
            'call_minutes' => 'invalid value',
            'exceeding_fee_percentage' => 'invalid value',
            'fare_price_per_minute' => 'invalid value',
            'plan_max_free_minutes' => 'invalid value'
        ];

        $dto = CallPriceCalculationDto::from($data);
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
    public function test_can_create_from_request_using_default_exceeding_fee_percentage(): void
    {
        $exceedingFeePercentage = 5;

        config()->set('callprice.configuration.exceeding_fee_percentage', $exceedingFeePercentage);

        $requestData = [
            'call_minutes' => 40,
            'fare_price_per_minute' => 1.90,
            'plan_max_free_minutes' => 30
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = CallPriceCalculationDto::from($request);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceCalculationDto::class, $dto);
        $this->assertEquals($requestData['call_minutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($exceedingFeePercentage, $dtoAsArray['exceeding_fee_percentage']);
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

    /**
     * @group dtos
     * @group callprice
     */
    public function test_cannot_create_from_request_with_invalid_values(): void
    {
        $this->expectException(ValidationException::class);

        $requestData = [
            'call_minutes' => 'invalid value',
            'exceeding_fee_percentage' => 'invalid value',
            'fare_price_per_minute' => 'invalid value',
            'plan_max_free_minutes' => 'invalid value'
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = CallPriceCalculationDto::from($request);
    }
}
