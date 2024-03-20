<?php

namespace Tests\Unit\App\Http\Controllers;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use App\Domain\Fare\Models\Fare;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;
use App\Http\Controllers\Api\FareController;

class FareControllerTest extends TestCase
{
    /** @var FareController */
    private $controller;

    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = Mockery::mock(FareServiceInterface::class);
        $this->controller = new FareController($this->serviceMock);
    }

    /**
     * @group controllers
     * @group fare
     */
    public function test_can_get_list_of_records(): void
    {
        Event::fake();
        Queue::fake();

        $recordsCount = 3;
        $generatedRecords = Fare::factory()->count($recordsCount)->make();

        $this->serviceMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($generatedRecords);

        $response = $this->controller->getAll();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($recordsCount, count($response->getData(true)['data']));
    }

    /**
     * @group controllers
     * @group fare
     */
    public function test_can_get_empty_list_of_records(): void
    {
        Event::fake();
        Queue::fake();

        $this->serviceMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(new Collection());

        $response = $this->controller->getAll();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(0, count($response->getData(true)['data']));
    }

    /**
     * @group controllers
     * @group fare
     */
    public function test_generates_log_if_cannot_get_list(): void
    {
        Event::fake();
        Queue::fake();

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, 'Failed to get list of fares.') !== false
                    && strpos($context['message'], 'Houston, we have a problem.') !== false;
            });

        $this->serviceMock
            ->shouldReceive('getAll')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.', Response::HTTP_BAD_REQUEST));

        $response = $this->controller->getAll();
        $responseAsArray = $response->getData(true);

        $this->assertEquals(
            'An error has occurred. Could not get the fares list as requested.',
            $responseAsArray['message']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
