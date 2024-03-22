<?php

namespace Tests\Unit\App\Domain\CallPrice\Services;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domain\CallPrice\DataTransferObjects\CallPriceCalculationDto;
use App\Domain\CallPrice\Exceptions\InvalidPlanMaxFreeMinutesException;
use App\Domain\CallPrice\Services\Interfaces\CalculateCallPriceServiceInterface;

class CalculateCallPriceServiceTest extends TestCase
{
    /** @var CalculateCallPriceServiceInterface */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(CalculateCallPriceServiceInterface::class);
    }

    /**
     * @group services
     * @group callprice
     */
    public function test_can_calculate_price_with_plan(): void
    {
        $data = [
            'call_minutes' => 80,
            'exceeding_fee_percentage' => 10,
            'fare_price_per_minute' => 1.70,
            'plan_max_free_minutes' => 60
        ];
        $dto = CallPriceCalculationDto::from($data);

        $result = $this->service->calculateWithPlan($dto);

        $this->assertIsNumeric($result);
        $this->assertEqualsWithDelta(37.40, $result, 0.0001);
    }

    /**
     * @group services
     * @group callprice
     */
    public function test_cannot_calculate_price_with_plan_without_max_free_minutes_value(): void
    {
        $this->expectException(InvalidPlanMaxFreeMinutesException::class);
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        $this->expectExceptionMessage(
            'Cannot proceed the calculation without a valid value for plan max free minutes.'
        );

        $data = [
            'call_minutes' => 80,
            'exceeding_fee_percentage' => 10,
            'fare_price_per_minute' => 1.70
        ];
        $dto = CallPriceCalculationDto::from($data);

        $result = $this->service->calculateWithPlan($dto);
    }

    /**
     * @group services
     * @group callprice
     */
    public function test_can_calculate_price_without_plan(): void
    {
        $data = [
            'call_minutes' => 80,
            'fare_price_per_minute' => 1.70
        ];
        $dto = CallPriceCalculationDto::from($data);

        $result = $this->service->calculateWithoutPlan($dto);

        $this->assertIsNumeric($result);
        $this->assertEqualsWithDelta(136, $result, 0.0001);
    }
}
