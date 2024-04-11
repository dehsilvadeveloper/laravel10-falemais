<?php

namespace Tests\Unit\App\Domain\Simulation\Services;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Domain\CallPrice\Services\Interfaces\CalculateCallPriceServiceInterface;
use App\Domain\Common\ValueObjects\DddObject;
use App\Domain\Fare\Exceptions\FareNotFoundException;
use App\Domain\Fare\Models\Fare;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;
use App\Domain\Plan\Exceptions\PlanNotFoundException;
use App\Domain\Plan\Models\Plan;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationResultDto;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;

class SimulateCallPriceServiceTest extends TestCase
{
    /** @var SimulateCallPriceServiceInterface */
    private $service;

    private $fareServiceMock;

    private $planServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fareServiceMock = Mockery::mock(FareServiceInterface::class);
        $this->planServiceMock = Mockery::mock(PlanServiceInterface::class);
        $this->service = app(
            SimulateCallPriceServiceInterface::class,
            [
                'fareService' => $this->fareServiceMock,
                'planService' => $this->planServiceMock,
                'calculateCallPriceService' => app(CalculateCallPriceServiceInterface::class)
            ]
        );
    }

    /**
     * @group services
     * @group simulation
     */
    public function test_can_simulate(): void
    {
        $dto = CallPriceSimulationDto::from([
            'ddd_origin' => new DddObject('011'),
            'ddd_destination' => new DddObject('017'),
            'call_minutes' => 80,
            'plan_id' => 2
        ]);

        $this->fareServiceMock
            ->shouldReceive('firstWhere')
            ->once()
            ->with([
                'ddd_origin' => $dto->dddOrigin->value(),
                'ddd_destination' => $dto->dddDestination->value()
            ])
            ->andReturn(
                Fare::factory()->make([
                    'ddd_origin' => '011',
                    'ddd_destination' => '017',
                    'price_per_minute' => 1.70
                ])
            );

        $this->planServiceMock
            ->shouldReceive('firstById')
            ->once()
            ->with($dto->planId)
            ->andReturn(
                Plan::factory()->make([
                    'name' => 'FaleMais 60',
                    'max_free_minutes' => 60
                ])
            );

        $result = $this->service->simulate($dto);

        $this->assertInstanceOf(CallPriceSimulationResultDto::class, $result);
        $this->assertEqualsWithDelta(37.40, $result->priceWithPlan, 0.0001);
        $this->assertEqualsWithDelta(136, $result->priceWithoutPlan, 0.0001);
    }

    /**
     * @group services
     * @group simulation
     */
    public function test_cannot_simulate_with_nonexistent_fare(): void
    {
        $this->expectException(FareNotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        $this->expectExceptionMessage(
            'Cannot proceed. Could no find a fare with the ddd origin and ddd destination provided.'
        );

        $dto = CallPriceSimulationDto::from([
            'ddd_origin' => new DddObject('998'),
            'ddd_destination' => new DddObject('999'),
            'call_minutes' => 80,
            'plan_id' => 2
        ]);

        $this->fareServiceMock
            ->shouldReceive('firstWhere')
            ->once()
            ->with([
                'ddd_origin' => $dto->dddOrigin->value(),
                'ddd_destination' => $dto->dddDestination->value()
            ])
            ->andReturn(null);

        $this->service->simulate($dto);
    }

    /**
     * @group services
     * @group simulation
     */
    public function test_cannot_simulate_with_nonexistent_plan(): void
    {
        $this->expectException(PlanNotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        $this->expectExceptionMessage(
            'Cannot proceed. Could no find a plan with the id provided.'
        );

        $dto = CallPriceSimulationDto::from([
            'ddd_origin' => new DddObject('011'),
            'ddd_destination' => new DddObject('017'),
            'call_minutes' => 80,
            'plan_id' => 999
        ]);

        $this->fareServiceMock
            ->shouldReceive('firstWhere')
            ->once()
            ->with([
                'ddd_origin' => $dto->dddOrigin->value(),
                'ddd_destination' => $dto->dddDestination->value()
            ])
            ->andReturn(
                Fare::factory()->make([
                    'ddd_origin' => '011',
                    'ddd_destination' => '017',
                    'price_per_minute' => 1.70
                ])
            );

        $this->planServiceMock
            ->shouldReceive('firstById')
            ->once()
            ->with($dto->planId)
            ->andReturn(null);

        $this->service->simulate($dto);
    }

    /**
     * @group services
     * @group simulation
     */
    public function test_generates_log_if_exception_occurs_when_try_to_simulate(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Houston, we have a problem.');

        $dto = CallPriceSimulationDto::from([
            'ddd_origin' => new DddObject('011'),
            'ddd_destination' => new DddObject('017'),
            'call_minutes' => 80,
            'plan_id' => 2
        ]);

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, '[CallPriceSimulationController] Failed to simulate the call price.') !== false
                    && strpos($context['error_message'], 'Houston, we have a problem.') !== false;
            });

        $this->fareServiceMock
            ->shouldReceive('firstWhere')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.'));

        $this->service->simulate($dto);
    }
}
