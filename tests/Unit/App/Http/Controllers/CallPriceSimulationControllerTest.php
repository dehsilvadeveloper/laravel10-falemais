<?php

namespace Tests\Unit\App\Http\Controllers;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationResultDto;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;
use App\Http\Controllers\Api\CallPriceSimulationController;
use App\Http\Requests\Api\SimulateCallPriceRequest;

class CallPriceSimulationControllerTest extends TestCase
{
    /** @var CallPriceSimulationController */
    private $controller;

    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = Mockery::mock(SimulateCallPriceServiceInterface::class);
        $this->controller = new CallPriceSimulationController($this->serviceMock);
    }

    /**
     * @group controllers
     * @group simulation
     */
    public function test_can_simulate(): void
    {
        Mail::fake();
        Event::fake();
        Notification::fake();
        Queue::fake();

        $this->serviceMock
            ->shouldReceive('simulate')
            ->once()
            ->andReturn(
                CallPriceSimulationResultDto::from([
                    'price_with_plan' => 37.40,
                    'price_without_plan' => 136
                ])
            );

        $requestData = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];
        $request = SimulateCallPriceRequest::create('/call-prices/simulate', 'POST', $requestData);

        $response = $this->controller->simulate($request);
        $responseAsArray = $response->getData(true);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEqualsWithDelta($responseAsArray['data']['price_with_plan'], 37.40, 0.0001);
        $this->assertEqualsWithDelta($responseAsArray['data']['price_without_plan'], 136, 0.0001);
    }

    /**
     * @group controllers
     * @group simulation
     */
    public function test_generates_log_if_cannot_simulate(): void
    {
        Mail::fake();
        Event::fake();
        Notification::fake();
        Queue::fake();

        $requestData = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];
        $request = SimulateCallPriceRequest::create('/call-prices/simulate', 'POST', $requestData);

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, '[CallPriceSimulationController] Failed to simulate the call price.') !== false
                    && strpos($context['error_message'], 'Houston, we have a problem.') !== false;
            });

        $this->serviceMock
            ->shouldReceive('simulate')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.', Response::HTTP_BAD_REQUEST));

        $response = $this->controller->simulate($request);
        $responseAsArray = $response->getData(true);

        $this->assertEquals(
            'An error has occurred. Could not simulate the call price as requested.',
            $responseAsArray['message']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
