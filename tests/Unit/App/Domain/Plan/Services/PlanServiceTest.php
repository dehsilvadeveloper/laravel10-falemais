<?php

namespace Tests\Unit\App\Domain\Plan\Services;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Domain\Plan\Models\Plan;
use App\Domain\Plan\Repositories\PlanRepositoryInterface;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;

class PlanServiceTest extends TestCase
{
    /** @var PlanServiceInterface */
    private $service;

    private $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(PlanRepositoryInterface::class);
        $this->service = app(PlanServiceInterface::class, ['planRepository' => $this->repositoryMock]);
    }

    /**
     * @group services
     * @group plan
     */
    public function test_can_get_list_of_records(): void
    {
        $recordsCount = 3;
        $generatedRecords = Plan::factory()->count($recordsCount)->make();
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $expectedData = new Collection($generatedRecordsAsArray);

        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($expectedData);

        $records = $this->service->getAll();
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['name'], $recordsAsArray[$i]['name']);
            $this->assertEquals(
                $generatedRecordsAsArray[$i]['max_free_minutes'],
                $recordsAsArray[$i]['max_free_minutes']
            );
        }
    }

    /**
     * @group services
     * @group plan
     */
    public function test_can_get_empty_list_of_records(): void
    {
        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(new Collection());

        $records = $this->service->getAll();

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }

    /**
     * @group services
     * @group plan
     */
    public function test_generates_log_in_case_of_exception(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Houston, we have a problem.');

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, 'Failed to get list of plans.') !== false
                    && strpos($context['message'], 'Houston, we have a problem.') !== false;
            });

        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.'));

        $this->service->getAll();
    }
}
